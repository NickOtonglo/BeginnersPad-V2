<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddWaitingListRequest;
use App\Http\Resources\PremiumPlanSubscription\PremiumPlanResource;
use App\Http\Resources\PremiumPlanSubscription\SubscriptionResource;
use App\Http\Resources\PremiumPlanSubscription\WaitingListResource;
use App\Models\PremiumPlan;
use App\Models\PremiumPlanSubscription;
use App\Models\PremiumPlanWaitingList;
use App\Models\Property;
use App\Models\SubZone;
use App\Models\System;
use App\Models\User;
use App\Models\UserCredit;
use App\Models\Zone;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PremiumSubscriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $subscriptions = $user->premiumSubscriptions;
        return SubscriptionResource::collection($subscriptions);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $plan = PremiumPlan::find($request->id);
        if ($plan->status == 'active') {
            // plan is active
            $user = auth()->user();
    
            if ($user->userCredit->credit >= $plan->price) {
                // credit is sufficient
                $this->createSubscription($plan, $request, $user);
            } else {
                //credit is insufficient
                return response()->json([
                    'message' => "Your credit amount is insufficient to subscribe to this plan.",
                    'errors' => [
                        'telephone' => [
                            "The credit amount is insufficient",
                        ]
                    ],
                ], 422);
            }
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function createSubscription(Request $request, User $user = null) {
        if (!$user) {
            $user = auth()->user();
        }
        $data = '';
        $plan = PremiumPlan::where('slug', $request->slug)->first();
        // $subscription = PremiumPlanSubscription::where('user_id', $user->id)->where('premium_plan_id', $plan->id)->firstOrFail();
        $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        $comment = '';

        if (!$this->transact($plan, $user->credit)) {
            return response()->json([
                'message' => "Your balance is insufficient. Kindly top-up your credit and try again.",
                'errors' => [
                    'credit' => [
                        "Balance is insufficient",
                    ]
                ],
            ], 422);
        }

        if ($subscription) {
            // https://stackoverflow.com/questions/19031235/php-check-if-date-is-past-to-a-certain-date-given-in-a-certain-format
            $expiry = new DateTime($subscription->expires_at);
            $now = new DateTime();

            if ($expiry > $now) {
                // expiry is in the future, valid subscripton is already in effect
                return response()->json([
                    'message' => "Your subscription to this plan is still active.",
                    'errors' => [
                        'subscription_plan' => [
                            "The subscription is still active",
                        ]
                    ],
                ], 422);
            }
            $data = $subscription;
        } else {
            $data = new PremiumPlanSubscription();
            $data->premium_plan_id = $plan->id;
            $data->user_id = $user->id;
        }
        $data->period = $plan->minimum_days;
        $data->activated_at = date("Y-m-d H:i:s");
        // https://www.codexworld.com/how-to/add-days-hours-minutes-seconds-to-datetime-php/
        $data->expires_at = date('Y-m-d H:i:s', strtotime('+'.$plan->minimum_days.' days', strtotime($data->activated_at)));
        $data->save();

        $response = [
            'premium_plan_subscription' => $data,
            'model' => 'PremiumPlanSubscription',
            'key' => $data->id,
            'comment' => $comment,
            'message' => "New subscription for plan ".$plan->name." activated for user @".$user->username.".",
        ];
        return response($response, 201);
    }

    public function addWaitingList(AddWaitingListRequest $request) {
        $comment = '';
        $user = auth()->user();
        $plan = PremiumPlan::where('slug', 'waiting-list')->first();
        $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        $limit = app(SystemController::class)->main(System::where('key', 'waiting_list_sub_limit')->first());

        // check for waiting list subscription limit
        if ($subscription->waitingLists()->count() >= intval($limit->value)) {
            return response()->json([
                'message' => "You have reached the maximum subscription limit of ".$limit->value." zones.",
                'errors' => [
                    'zone_id' => [
                        "You have reached the maximum subscription limit",
                    ]
                ],
            ], 422);
        }

        $zone = Zone::find($request->zone_id);

        $data = new PremiumPlanWaitingList();
        $data->subscription_id = $subscription->id;
        $data->zone_id = $request->zone_id;
        try {
            $data->save();
        } catch (Exception $e) {
            return response()->json([
                'message' => "You are already in this zone's waiting list.",
                'errors' => [
                    'zone_id' => [
                        "You are aleady in this zone's waiting list",
                    ]
                ],
            ], 422);
        }

        $response = [
            'premium_plan_waiting_list' => new WaitingListResource($data),
            'message' => "New waiting list added for zone ".$zone->name." under subscription #".$subscription->id." for user @".$user->username.".",
        ];
        return response($response, 201);
    }

    public function removeWaitingList(Zone $zone) {
        $comment = '';
        $user = auth()->user();
        $plan = PremiumPlan::where('slug', 'waiting-list')->first();
        $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        
        $data = $subscription->waitingLists()->where('zone_id', $zone->id)->first();
        $data->delete();

        $response = [
            'premium_plan_waiting_list' => response()->noContent(),
            'message' => "Waiting list for zone ".$zone->name." under subscription #".$subscription->id." for user @".$user->username." removed.",
        ];
        return response($response, 201);
    }

    public function getWaitingListSubscription() {
        $plan = PremiumPlan::where('slug', 'waiting-list')->first();

        try {
            $subscription = auth()->user()->premiumSubscriptions()->where('premium_plan_id', $plan->id)->firstOrFail();
            return new SubscriptionResource($subscription);
        } catch (Exception $e) {
            return response()->noContent();
        }
    }

    public function getPremiumPlan(PremiumPlan $plan) {
        return new PremiumPlanResource($plan);
    }

    public function getUserWaitingLists(User $user, PremiumPlan $plan = null, PremiumPlanSubscription $subscription = null) {
        if (!$plan) {
            $plan = PremiumPlan::where('slug', 'waiting-list')->first();
        }

        if (!$subscription) {
            $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        }

        $waitingLists = $subscription->waitingLists;
        return $waitingLists;
    }

    public function transact(PremiumPlan $plan, UserCredit $credit) {
        $planPrice = $plan->price;
        $creditBalance = $credit->credit;

        if ($creditBalance >= $planPrice) {
            // dd($creditBalance.' >= '.$planPrice);
            // dd(-$planPrice);
            app(UserCreditController::class)->update($credit, floatval(-$planPrice), boolval($credit->auto_pay), $credit->user, null, true);
            return true;
        } else {
            // dd($creditBalance.' < '.$planPrice);
            return false;
        }
    }

    public function doesUserHaveValidWaitingListSubscription(User $user, PremiumPlan $plan = null, PremiumPlanSubscription $subscription = null) {
        if (!$plan) {
            $plan = PremiumPlan::where('slug', 'waiting-list')->first();
        }

        if (!$subscription) {
            $subscription = $user->premiumSubscriptions()->where('premium_plan_id', $plan->id)->first();
        }

        if ($subscription) {
            // check if subscription is valid
            $expiry = new DateTime($subscription->expires_at);
            $now = new DateTime();
            if ($expiry > $now) {
                // expiry is in the future, subscription is valid
                return true;
            } else {
                // subscription is invalid
            }
        }
        return false;
    }

    public function getWaitingListSubscriberListings(User $user, $properties, PremiumPlan $plan = null, PremiumPlanSubscription $subscription = null, $pagination = 25, $order = 'desc') {
        if ($order == 'desc') {
            $order = 'asc';
        } else if ($order == 'asc') {
            $order = 'desc';
        }
        
        // get user's waiting lists
        $waitingLists = $this->getUserWaitingLists($user, $plan, $subscription);
        if ($waitingLists->count() > 0) {
            $list = [];
            foreach ($waitingLists as $waitingList) {
                // $item = $waitingList->zone->properties()->where('status', 'published')
                //                                         ->where('published_at', '>=', Carbon::now()->subHours(48))
                //                                         ->get();

                // get listings in waiting lists that have been published within the last 48 hrs
                $items = $waitingList->zone->properties()->where('status', 'published')
                ->where('published_at', '>=', Carbon::now()->subHours(48))
                    ->orderBy('published_at', $order)
                    ->get();
                foreach ($items as $item) {
                    array_push($list, $item);
                }
            }
            $properties = $properties->where('status', 'published')
            ->where('published_at', '<', Carbon::now()->subHours(48))
                ->orderBy('published_at', $order);

            // add listings to collection
            $properties = new Collection($properties->get());
            $properties = $properties->merge($list);
            if ($order = 'desc') {
                $properties = $properties->reverse()->values();
            }

            if ($pagination > 0) {
                $properties = app(Controller::class)->paginate($properties, $pagination);
            }
        }
        return $properties;
    }

    public function getWaitingListSubscriberListingsInSubZone(User $user, $properties, PremiumPlan $plan = null, PremiumPlanSubscription $subscription = null, $pagination = 25, SubZone $subZone = null, $order = 'desc') {
        if ($order == 'desc') {
            $order = 'asc';
        } else if ($order == 'asc') {
            $order = 'desc';
        }
        
        // check if user has valid waiting list subscription
        // get user's waiting lists
        // get listings in zone's waiting list that have been posted within the last 48 hrs
        // check if listing belongs to selected sub-zone
        // if listing belongs to selected sub-zone, add to array
        // add listings to collection
        $waitingLists = $this->getUserWaitingLists($user, $plan, $subscription);
        if ($waitingLists->count() > 0) {
            $list = [];
            foreach ($waitingLists as $waitingList) {
                $items = $waitingList->zone->properties()->where('status', 'published')
                                                        ->where('published_at', '>=', Carbon::now()->subHours(48))
                                                        ->orderBy('published_at', $order)
                                                        ->get();
                foreach ($items as $item) {
                    if ($item->sub_zone_id == $subZone->id) {
                        array_push($list, $item);
                    }
                }
            }
            $properties = $properties->where('status', 'published')
            ->where('published_at', '<', Carbon::now()->subHours(48))
                ->orderBy('published_at', $order);

            // add listings to collection
            $properties = new Collection($properties->get());
            $properties = $properties->merge($list);

            if ($order = 'desc') {
                $properties = $properties->reverse()->values();
            }

            if ($pagination > 0) {
                $properties = app(Controller::class)->paginate($properties, $pagination);
            }

            $properties = app(Controller::class)->paginate($properties, $pagination);
        }
        return $properties;
    }

    public function isPropertyAccessibleToUser(User $user, Property $property) {
        if ($this->doesUserHaveValidWaitingListSubscription($user)) {
            $zone = $property->subZone->zone;
            $waitingList = $this->getUserWaitingLists($user);
            $waitingList = $waitingList->where('zone_id', $zone->id)->first();
            if ($waitingList) {
                return true;
            }
        }
        return false;
    }
}
