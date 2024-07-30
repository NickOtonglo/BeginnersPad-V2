<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HelpTicket;
use App\Models\PremiumPlan;
use App\Models\Property;
use App\Models\PropertyReview;
use App\Models\PropertyReviewRemovalLog;
use App\Models\PropertyUnit;
use App\Models\SubZone;
use App\Models\User;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function preLoad() {
        $user = auth()->user();
        if ($user->role_id == 5) {
            return $this->getBeginnerData($user);
        }
        if ($user->role_id == 4) {
            return $this->getListerData($user);
        }
        if ($user->role_id <= 3 && $user->role_id >= 1) {
            return $this->getAdminData($user);
        }
    }

    public function getBeginnerData($user) {
        $subZone_zone = app(ZonesController::class)->getZoneByMostListed();
        $zoneHighestListed = $subZone_zone->zone;
        $subZoneHighestListed = $subZone_zone;
        $zoneHighestRated = app(ZonesController::class)->getZoneByRating('highest');
        $zoneHighestRatedMeanRent = app(ZonesController::class)->getZoneAverageRent(Zone::where('id', $zoneHighestRated)->first());
        $zoneLowestRent = app(ZonesController::class)->getZoneByRent('lowest');

        $tickets = $user->helpTickets()->count();
        $ticketsOpen = $user->helpTickets()->where('status', 'open')->count();
        $ticketsPending = $user->helpTickets()->where('status', 'pending')->count();
        $ticketsResolved = $user->helpTickets()->where('status', 'resolved')->count();
        $ticketsClosed = $user->helpTickets()->where('status', 'closed')->count();

        $reviews = $user->propertyReviews()->count();
        $reviewsRemoved = PropertyReviewRemovalLog::where('author_id', $user->id)->count();
        $reviewsRemovedMostCommonReason = PropertyReviewRemovalLog::select('removal_reason')->groupBy('removal_reason')
                                                                    ->orderByRaw('COUNT(*) DESC')
                                                                    ->where('author_id', $user->id)->get();
        $reviewsVal1 = $user->propertyReviews()->where('rating', 1.0)->count();
        $reviewsVal2 = $user->propertyReviews()->where('rating', 2.0)->count();
        $reviewsVal3 = $user->propertyReviews()->where('rating', 3.0)->count();
        $reviewsVal4 = $user->propertyReviews()->where('rating', 4.0)->count();
        $reviewsVal5 = $user->propertyReviews()->where('rating', 5.0)->count();

        $favourites = $user->userFavourites()->count();
        $favArticles = $user->userFavourites()->where('model', 'Article')->count();
        $favProperties = $user->userFavourites()->where('model', 'Property')->count();
        $favUnits = $user->userFavourites()->where('model', 'PropertyUnit')->count();

        $waitingListStatus = 'invalid';
        $waitingListTimeLeft = 'n/a';
        if (app(PremiumSubscriptionsController::class)->doesUserHaveValidWaitingListSubscription($user)) {
            $plan = PremiumPlan::where('slug', 'waiting-list')->first();
            $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
            $waitingListStatus = 'valid';
            $waitingListTimeLeft = Carbon::parse($subscription->expires_at)->diffForHumans(
                now(),
                Carbon::DIFF_ABSOLUTE,
                false,
                2
            );
        }
        $waitingListMostPopular = app(PremiumSubscriptionsController::class)->getWaitingListByPopularity(false);
        $waitingListActiveListings = app(PremiumSubscriptionsController::class)->getAllActiveListingsCount();
        $waiting_list_most_popular_list_1 = $waitingListMostPopular[0]->name.', '.Zone::find($waitingListMostPopular[0]->id)->zoneCounty->name;
        $waiting_list_most_popular_list_2 = $waitingListMostPopular[1]->name.', '.Zone::find($waitingListMostPopular[1]->id)->zoneCounty->name;
        $waiting_list_most_popular_list_3 = $waitingListMostPopular[2]->name.', '.Zone::find($waitingListMostPopular[2]->id)->zoneCounty->name;

        $zone_highest_listed = $zoneHighestListed->name.', '.$zoneHighestListed->zoneCounty->name;
        $zones_highest_ratings = [$zoneHighestRated[1].', '.Zone::find($zoneHighestRated[0])->zoneCounty->name, $zoneHighestRated[2]];
        $zones_cheapest_rent = [$zoneLowestRent[1].', '.Zone::find($zoneLowestRent[0])->zoneCounty->name, intval($zoneLowestRent[2]/100)/10];

        return response()->json([
            // listings
            'zone_highest_listed' => $zone_highest_listed,
            'sub_zone_highest_listed' => $subZoneHighestListed->name,
            'zones_highest_ratings' => $zones_highest_ratings,
            'zones_highest_ratings_average_rent' => intval($zoneHighestRatedMeanRent/100)/10,
            'zones_cheapest_rent' => $zones_cheapest_rent,
            // 'zones_most_reviews' => '',

            // Tickets
            'tickets_all' => $tickets,
            'tickets_open' => $ticketsOpen,
            'tickets_pending' => $ticketsPending,
            'tickets_resolved' => $ticketsResolved,
            'tickets_closed' => $ticketsClosed,

            // Reviews
            'reviews_posted' => $reviews,
            // 'reviews_flagged' => '',
            'reviews_removed' => $reviewsRemoved,
            // 'reviews_removed_most_common_reason' => $reviewsRemovedMostCommonReason,
            'reviews_rating_dist_1' => $reviewsVal1,
            'reviews_rating_dist_2' => $reviewsVal2,
            'reviews_rating_dist_3' => $reviewsVal3,
            'reviews_rating_dist_4' => $reviewsVal4,
            'reviews_rating_dist_5' => $reviewsVal5,

            // Favourites
            'favourites_all' => $favourites,
            'favourites_articles' => $favArticles,
            'favourites_properties' => $favProperties,
            'favourites_units' => $favUnits,

            // Waiting list
            'waiting_list_status' => $waitingListStatus,
            'waiting_list_time_left' => $waitingListTimeLeft,
            'waiting_list_most_popular_list_1' => $waiting_list_most_popular_list_1,
            'waiting_list_most_popular_list_2' => $waiting_list_most_popular_list_2,
            'waiting_list_most_popular_list_3' => $waiting_list_most_popular_list_3,
            'waiting_list_property_listings_active' => $waitingListActiveListings,
            // 'waiting_list_property_listings_published_within_last_48h' => $waitingListActiveListings,
            // chart showing waiting list zones
        ]);
    }

    public function getListerData($user) {
        $subZone_zone = app(ZonesController::class)->getZoneByMostListed();
        $zoneHighestListed = $subZone_zone->zone;
        $subZoneHighestListed = $subZone_zone;
        $zoneHighestRated = app(ZonesController::class)->getZoneByRating('highest');
        $zoneHighestRatedMeanRent = app(ZonesController::class)->getZoneAverageRent(Zone::where('id', $zoneHighestRated)->first());
        $zoneLowestRent = app(ZonesController::class)->getZoneByRent('lowest');

        $tickets = $user->helpTickets()->count();
        $ticketsOpen = $user->helpTickets()->where('status', 'open')->count();
        $ticketsPending = $user->helpTickets()->where('status', 'pending')->count();
        $ticketsResolved = $user->helpTickets()->where('status', 'resolved')->count();
        $ticketsClosed = $user->helpTickets()->where('status', 'closed')->count();

        $favourites = $user->userFavourites()->count();
        $favArticles = $user->userFavourites()->where('model', 'Article')->count();
        $favProperties = $user->userFavourites()->where('model', 'Property')->count();
        $favUnits = $user->userFavourites()->where('model', 'PropertyUnit')->count();

        $listingsAll = $user->properties()->count();
        $listingsUnsubmitted = $user->properties()->where('status','unpublished')->count();
        $listingsPending = $user->properties()->where('status','pending')->count();
        $listingsPublished = $user->properties()->where('status','published')->count();
        $listingsRejected = $user->properties()->where('status','rejected')->count();
        $listingsSuspended = $user->properties()->where('status','suspended')->count();
        $listingsHidden = $user->properties()->where('status','hidden')->count();
        $listingsUnitsAll = $user->propertyUnits()->count();
        $listingsUnitsHidden = $user->propertyUnits()->where('property_units.status', 'inactive')->count();
        $listingAverageRating = app(PropertiesController::class)->getMyListingsAverageRating();

        $zone_highest_listed = $zoneHighestListed->name.', '.$zoneHighestListed->zoneCounty->name;
        $zones_highest_ratings = [$zoneHighestRated[1].', '.Zone::find($zoneHighestRated[0])->zoneCounty->name, $zoneHighestRated[2]];
        $zones_cheapest_rent = [$zoneLowestRent[1].', '.Zone::find($zoneLowestRent[0])->zoneCounty->name, intval($zoneLowestRent[2]/100)/10];

        return response()->json([
            // listings
            'zone_highest_listed' => $zone_highest_listed,
            'sub_zone_highest_listed' => $subZoneHighestListed->name,
            'zones_highest_ratings' => $zones_highest_ratings,
            'zones_highest_ratings_average_rent' => intval($zoneHighestRatedMeanRent/100)/10,
            'zones_cheapest_rent' => $zones_cheapest_rent,
            // 'zones_most_reviews' => '',

            // My listings
            'listings_all' => $listingsAll,
            'listings_unsubmitted' => $listingsUnsubmitted,
            'listings_pending' => $listingsPending,
            'listings_published' => $listingsPublished,
            'listings_rejected' => $listingsRejected,
            'listings_suspended' => $listingsSuspended,
            'listings_hidden' => $listingsHidden,
            'listings_units_all' => $listingsUnitsAll,
            'listings_units_hidden' => $listingsUnitsHidden,
            'listings_average_rating' => number_format($listingAverageRating, 1, '.', ''),

            // Tickets
            'tickets_all' => $tickets,
            'tickets_open' => $ticketsOpen,
            'tickets_pending' => $ticketsPending,
            'tickets_resolved' => $ticketsResolved,
            'tickets_closed' => $ticketsClosed,

            // Favourites
            'favourites_all' => $favourites,
            'favourites_articles' => $favArticles,
            'favourites_properties' => $favProperties,
            'favourites_units' => $favUnits,
        ]);
    }

    public function getAdminData($user) {
        $listingsAll = Property::count();
        $listingsUnsubmitted = Property::where('status','unpublished')->count();
        $listingsPending = Property::where('status','pending')->count();
        $listingsPublished = Property::where('status','published')->count();
        $listingsRejected = Property::where('status','rejected')->count();
        $listingsSuspended = Property::where('status','suspended')->count();
        $listingsHidden = Property::where('status','hidden')->count();
        $listingsUnitsAll = PropertyUnit::count();
        $listingsUnitsHidden = PropertyUnit::where('status', 'inactive')->count();
        $listingAverageRating = PropertyReview::avg('rating');
        
        $favourites = $user->userFavourites()->count();
        $favArticles = $user->userFavourites()->where('model', 'Article')->count();
        $favProperties = $user->userFavourites()->where('model', 'Property')->count();
        $favUnits = $user->userFavourites()->where('model', 'PropertyUnit')->count();

        $tickets = HelpTicket::count();
        $ticketsOpen = HelpTicket::where('status', 'open')->count();
        $ticketsPending = HelpTicket::where('status', 'pending')->count();
        $ticketsResolved = HelpTicket::where('status', 'resolved')->count();
        $ticketsClosed = HelpTicket::where('status', 'closed')->count();
        $ticketsMeAssigned = HelpTicket::where('status', 'pending')->where('assigned_to', $user->username)->count();
        $ticketsMeClosed = HelpTicket::where('status', 'closed')->where('assigned_to', $user->username)->count();

        $subZone_zone = app(ZonesController::class)->getZoneByMostListed();
        $zoneHighestListed = $subZone_zone->zone;
        $subZoneHighestListed = $subZone_zone;
        $zoneHighestRated = app(ZonesController::class)->getZoneByRating('highest');
        $zoneHighestRatedMeanRent = app(ZonesController::class)->getZoneAverageRent(Zone::where('id', $zoneHighestRated)->first());
        $zoneLowestRent = app(ZonesController::class)->getZoneByRent('lowest');
        $zone_highest_listed = $zoneHighestListed->name.', '.$zoneHighestListed->zoneCounty->name;
        $zones_highest_ratings = [$zoneHighestRated[1].', '.Zone::find($zoneHighestRated[0])->zoneCounty->name, $zoneHighestRated[2]];
        $zones_cheapest_rent = [$zoneLowestRent[1].', '.Zone::find($zoneLowestRent[0])->zoneCounty->name, intval($zoneLowestRent[2]/100)/10];
        $zones = Zone::count();
        $subZones = SubZone::count();

        $waitingListMostPopular = app(PremiumSubscriptionsController::class)->getWaitingListByPopularity(false);
        $waitingListActiveListings = app(PremiumSubscriptionsController::class)->getAllActiveListingsCount();
        $waiting_list_most_popular_list_1 = $waitingListMostPopular[0]->name.', '.Zone::find($waitingListMostPopular[0]->id)->zoneCounty->name;
        $waiting_list_most_popular_list_2 = $waitingListMostPopular[1]->name.', '.Zone::find($waitingListMostPopular[1]->id)->zoneCounty->name;
        $waiting_list_most_popular_list_3 = $waitingListMostPopular[2]->name.', '.Zone::find($waitingListMostPopular[2]->id)->zoneCounty->name;

        $reviews = PropertyReview::count();
        $reviewsRemoved = PropertyReviewRemovalLog::where('author_id', $user->id)->count();
        $reviewsRemovedMostCommonReason = PropertyReviewRemovalLog::select('removal_reason')->groupBy('removal_reason')
                                                                    ->orderByRaw('COUNT(*) DESC')->get();
        $reviewsVal1 = PropertyReview::where('rating', 1.0)->count();
        $reviewsVal2 = PropertyReview::where('rating', 2.0)->count();
        $reviewsVal3 = PropertyReview::where('rating', 3.0)->count();
        $reviewsVal4 = PropertyReview::where('rating', 4.0)->count();
        $reviewsVal5 = PropertyReview::where('rating', 5.0)->count();                                                            
        
        $users = User::count();
        $usersAdmin = User::where('role_id', '>=', 1)->where('role_id', '<=', 3)->count();
        $usersLister = User::where('role_id', 4)->count();
        $usersBeginner = User::where('role_id', 5)->count();
        $usersOther = User::where('role_id', 6)->count();

        return response()->json([
            'listings_all' => $listingsAll,
            'listings_unsubmitted' => $listingsUnsubmitted,
            'listings_pending' => $listingsPending,
            'listings_published' => $listingsPublished,
            'listings_rejected' => $listingsRejected,
            'listings_suspended' => $listingsSuspended,
            'listings_hidden' => $listingsHidden,
            'listings_units_all' => $listingsUnitsAll,
            'listings_units_hidden' => $listingsUnitsHidden,
            'listings_average_rating' => number_format($listingAverageRating, 2, '.', ''),

            'favourites_all' => $favourites,
            'favourites_articles' => $favArticles,
            'favourites_properties' => $favProperties,
            'favourites_units' => $favUnits,

            'reviews_posted' => $reviews,
            'reviews_removed' => $reviewsRemoved,
            'reviews_removed_most_common_reason' => $reviewsRemovedMostCommonReason,
            'reviews_rating_dist_1' => $reviewsVal1,
            'reviews_rating_dist_2' => $reviewsVal2,
            'reviews_rating_dist_3' => $reviewsVal3,
            'reviews_rating_dist_4' => $reviewsVal4,
            'reviews_rating_dist_5' => $reviewsVal5,

            'users_all' => $users,
            'users_admins' => $usersAdmin,
            'users_listers' => $usersLister,
            'users_beginners' => $usersBeginner,
            'users_others' => $usersOther,

            'tickets_all' => $tickets,
            'tickets_open' => $ticketsOpen,
            'tickets_pending' => $ticketsPending,
            'tickets_resolved' => $ticketsResolved,
            'tickets_closed' => $ticketsClosed,
            'tickets_assigned_to_me' => $ticketsMeAssigned,
            'tickets_closed_by_me' => $ticketsMeClosed,

            'zones_all' => $zones,
            'zones_sub_all' => $subZones,
            'zone_highest_listed' => $zone_highest_listed,
            'sub_zone_highest_listed' => $subZoneHighestListed->name,
            'zones_highest_ratings' => $zones_highest_ratings,
            'zones_highest_ratings_average_rent' => intval($zoneHighestRatedMeanRent/100)/10,
            'zones_cheapest_rent' => $zones_cheapest_rent,
            
            'waiting_list_most_popular_list_1' => $waiting_list_most_popular_list_1,
            'waiting_list_most_popular_list_2' => $waiting_list_most_popular_list_2,
            'waiting_list_most_popular_list_3' => $waiting_list_most_popular_list_3,
            'waiting_list_property_listings_active' => $waitingListActiveListings,
        ]);
    }
}
