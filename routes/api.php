<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::get('system/{key}', '\App\Http\Controllers\Api\SystemController@main');

Route::get('articles', '\App\Http\Controllers\Api\ArticlesController@index');
Route::get('articles/{article}', '\App\Http\Controllers\Api\ArticlesController@show');
Route::get('articles/{article}/author', '\App\Http\Controllers\Api\ArticlesController@getAuthorName');

Route::get('articles/{article}/tags', '\App\Http\Controllers\Api\ArticlesController@getTags');
Route::get('tags/{tag}', '\App\Http\Controllers\Api\TagsController@show');
Route::get('tags/{tag}/articles', '\App\Http\Controllers\Api\TagsController@getArticles');

Route::get('listings/home', '\App\Http\Controllers\Api\PropertiesController@indexHome');
Route::get('listings', '\App\Http\Controllers\Api\PropertiesController@index');

Route::get('listings/units/all', 'App\Http\Controllers\Api\PropertyUnitsController@getUnitsQuery');
Route::get('listings/units/sub-zone/{sub_zone}', 'App\Http\Controllers\Api\PropertyUnitsController@getUnitsBySubZone');

Route::get('help/faq', '\App\Http\Controllers\Api\HelpController@getFaqs');
Route::get('help/topics', '\App\Http\Controllers\Api\HelpController@getTopics');
Route::post('help/tickets', '\App\Http\Controllers\Api\HelpController@storeTicket')->middleware('logs.user');

Route::middleware(['auth:sanctum', 'logs.user'])->group(function() {
    
    Route::middleware(['validate.admin'])->group(function() {
        Route::post('articles', '\App\Http\Controllers\Api\ArticlesController@store');
        Route::patch('articles/{article}', '\App\Http\Controllers\Api\ArticlesController@update');
        Route::delete('articles/{article}', '\App\Http\Controllers\Api\ArticlesController@destroy');
        Route::get('articles/my-articles/manage', '\App\Http\Controllers\Api\ArticlesController@getMyArticles');
        
        Route::post('tags', '\App\Http\Controllers\Api\TagsController@store');
        Route::patch('tags/{tag}', '\App\Http\Controllers\Api\TagsController@update');
        Route::delete('tags/{tag}', '\App\Http\Controllers\Api\TagsController@destroy');
        
        Route::post('zones', '\App\Http\Controllers\Api\ZonesController@store');
        Route::patch('zones/{zone}', '\App\Http\Controllers\Api\ZonesController@update');
        Route::delete('zones/{zone}', '\App\Http\Controllers\Api\ZonesController@destroy');
        
        Route::post('zones/{zone}/sub-zones', '\App\Http\Controllers\Api\SubZoneController@store');
        Route::patch('zones/{zone}/sub-zones/{subZone}', '\App\Http\Controllers\Api\SubZoneController@update');
        Route::delete('zones/{zone}/sub-zones/{subZone}', '\App\Http\Controllers\Api\SubZoneController@destroy');
        
        Route::get('listings/logs/all', '\App\Http\Controllers\Api\PropertiesController@getAllLogs');
        
        Route::post('listings/{property}/reviews/{review}', 'App\Http\Controllers\Api\PropertyReviewsController@removeReview');
        
        Route::get('reviews/removal/reasons', 'App\Http\Controllers\Api\PropertyReviewsController@getRemovalReasons');
        Route::get('reviews/removal/logs', 'App\Http\Controllers\Api\PropertyReviewsController@getRemovalLogs');
        
        Route::post('help/faq', '\App\Http\Controllers\Api\HelpController@storeFaqs');
        Route::patch('help/faq/{faq}', '\App\Http\Controllers\Api\HelpController@updateFaq');
        Route::delete('help/faq/{faq}', '\App\Http\Controllers\Api\HelpController@destroyFaq');
        
        Route::get('help/tickets/manage/all', '\App\Http\Controllers\Api\HelpController@getTicketsAll');
        Route::get('help/tickets/manage/reps', '\App\Http\Controllers\Api\HelpController@getTicketsReps');
        Route::get('help/tickets/manage/reps/{user}', '\App\Http\Controllers\Api\HelpController@getRepresentativeTickets');
        Route::get('help/tickets/manage/user/{user}', '\App\Http\Controllers\Api\HelpController@getTicketsByUser');
        Route::patch('help/tickets/manage/ticket/{ticket}', '\App\Http\Controllers\Api\HelpController@updateTicketStatus');
        
        Route::get('users/roles/all', '\App\Http\Controllers\Api\UserController@getRoles');
        Route::get('users/logs/all', '\App\Http\Controllers\Api\UserController@getLogs');
        Route::get('users/{role}', '\App\Http\Controllers\Api\UserController@getUsersByRole');
        Route::get('users', '\App\Http\Controllers\Api\UserController@getAllUsers');
        Route::post('users', '\App\Http\Controllers\Api\UserController@saveUser');
        Route::get('users/profile/{user}', '\App\Http\Controllers\Api\UserController@getUser');
        Route::patch('users/profile/{user}', '\App\Http\Controllers\Api\UserController@updateUser');
    });
    
    Route::middleware(['validate.lister'])->group(function() {
        Route::post('brand/avatar', '\App\Http\Controllers\Api\UserController@updateBrandAvatar');
        Route::delete('brand/avatar', '\App\Http\Controllers\Api\UserController@removeBrandAvatar');
        Route::patch('brand', '\App\Http\Controllers\Api\UserController@updateBrand');
        Route::post('brand', '\App\Http\Controllers\Api\UserController@saveBrand');
        
        Route::get('listings/my-listings', '\App\Http\Controllers\Api\PropertiesController@getMyListings');
        Route::get('listings/my-listings/status/{status}', '\App\Http\Controllers\Api\PropertiesController@getMyListingsByStatus');
        Route::get('listings/my-listings/sub-zone/{sub_zone}', '\App\Http\Controllers\Api\PropertiesController@getMyListingsBySubZone');
        Route::get('listings/my-listings/{property}', '\App\Http\Controllers\Api\PropertiesController@showMyListing');
        Route::post('listings', '\App\Http\Controllers\Api\PropertiesController@store');
        Route::patch('listings/{property}', '\App\Http\Controllers\Api\PropertiesController@update');
        Route::post('listings/{property}/features', '\App\Http\Controllers\Api\PropertiesController@storeFeatures');
        Route::delete('listings/{property}/features/{feature}', '\App\Http\Controllers\Api\PropertiesController@destroyFeature');
        Route::post('listings/{property}/files', '\App\Http\Controllers\Api\PropertiesController@storeFiles');
        Route::delete('listings/{property}/files/{file}', '\App\Http\Controllers\Api\PropertiesController@destroyFile');
        Route::post('listings/{property}/thumbnail', '\App\Http\Controllers\Api\PropertiesController@updateThumbnail');
        
        Route::post('listings/{property}', 'App\Http\Controllers\Api\PropertyUnitsController@store');
        
        Route::patch('listings/{property}/units/{unit}', 'App\Http\Controllers\Api\PropertyUnitsController@update');
        Route::delete('listings/{property}/units/{unit}', 'App\Http\Controllers\Api\PropertyUnitsController@destroy');
        Route::patch('listings/{property}/units/{unit}/status', 'App\Http\Controllers\Api\PropertyUnitsController@updateStatus');
        Route::post('listings/{property}/units/{unit}/features', 'App\Http\Controllers\Api\PropertyUnitsController@storeFeatures');
        Route::delete('listings/{property}/units/{unit}/features/{feature}', '\App\Http\Controllers\Api\PropertyUnitsController@destroyFeature');
        Route::post('listings/{property}/units/{unit}/files', '\App\Http\Controllers\Api\PropertyUnitsController@storeFiles');
        Route::delete('listings/{property}/units/{unit}/files/{file}', '\App\Http\Controllers\Api\PropertyUnitsController@destroyFile');
        Route::post('listings/{property}/units/{unit}/thumbnail', '\App\Http\Controllers\Api\PropertyUnitsController@updateThumbnail');
        Route::patch('listings/{property}/units/{unit}/disclaimer', '\App\Http\Controllers\Api\PropertyUnitsController@storeDisclaimer');
    });

    Route::middleware(['validate.beginner'])->group(function() {
        Route::post('listings/{property}/enquire', '\App\Http\Controllers\Api\PropertiesController@sendEnquiry');
        Route::post('listings/{property}/units/{unit}/enquire', '\App\Http\Controllers\Api\PropertyUnitsController@sendEnquiry');
        
        Route::get('reviews', 'App\Http\Controllers\Api\PropertyReviewsController@getMyReviews');
        Route::get('reviews/{property}', 'App\Http\Controllers\Api\PropertyReviewsController@showMyReview');
        
        Route::post('listings/{property}/reviews', 'App\Http\Controllers\Api\PropertyReviewsController@store');
        Route::patch('listings/{property}/reviews/{review}', 'App\Http\Controllers\Api\PropertyReviewsController@update');
        Route::delete('listings/{property}/reviews/{review}', 'App\Http\Controllers\Api\PropertyReviewsController@destroy');
        
        Route::get('premium/plans/waiting-list', '\App\Http\Controllers\Api\PremiumSubscriptionsController@getWaitingListSubscription');
        Route::post('premium/plans/waiting-list', '\App\Http\Controllers\Api\PremiumSubscriptionsController@addWaitingList');
        Route::delete('premium/plans/waiting-list/{zone}', '\App\Http\Controllers\Api\PremiumSubscriptionsController@removeWaitingList');
    });
    
    Route::middleware(['validate.admin.lister'])->group(function() {
        Route::delete('listings/{property}', '\App\Http\Controllers\Api\PropertiesController@destroy');
        Route::patch('listings/{property}/status', '\App\Http\Controllers\Api\PropertiesController@updateStatus');
        
        Route::get('listings/{property}/logs', '\App\Http\Controllers\Api\PropertiesController@getLogs');
    });
    
    Route::middleware(['validate.admin.beginner'])->group(function() {
        
    });
    
    Route::middleware(['validate.lister.beginner'])->group(function() {
        // authenticated user's tickets
        Route::get('help/tickets', '\App\Http\Controllers\Api\HelpController@getTickets');
        Route::get('help/tickets/status/{status}', '\App\Http\Controllers\Api\HelpController@getTicketsWithStatus');
        Route::put('help/tickets/{ticket}', '\App\Http\Controllers\Api\HelpController@updateTicket');
        Route::patch('help/tickets/{ticket}', '\App\Http\Controllers\Api\HelpController@updateTicketStatus');
        Route::delete('help/tickets/{ticket}', '\App\Http\Controllers\Api\HelpController@destroyTicket');
        
        Route::post('premium/subscriptions', '\App\Http\Controllers\Api\PremiumSubscriptionsController@createSubscription');
        
        Route::get('user/credit/check', '\App\Http\Controllers\Api\UserCreditController@doesUserHaveCreditAccount');
        Route::post('user/credit', '\App\Http\Controllers\Api\UserCreditController@prePost');
        Route::get('user/credit', '\App\Http\Controllers\Api\UserCreditController@show');
        Route::patch('user/credit', '\App\Http\Controllers\Api\UserCreditController@prePost');
    });

    Route::get('dashboard', '\App\Http\Controllers\Api\DashboardController@preLoad');
    
    Route::get('user', '\App\Http\Controllers\Api\UserController@getAuthenticatedUser');
    Route::get('user/account', '\App\Http\Controllers\Api\UserController@getAuthenticatedUserAccount');
    Route::post('user/account', '\App\Http\Controllers\Api\UserController@updateAccount');
    Route::post('user/avatar', '\App\Http\Controllers\Api\UserController@updateAvatar');
    Route::delete('user/avatar', '\App\Http\Controllers\Api\UserController@removeAvatar');
    Route::post('user/secret', '\App\Http\Controllers\Api\UserController@updatePassword');
    Route::post('user/view/{user}', '\App\Http\Controllers\Api\UserController@showUser');

    Route::get('help/tickets/{ticket}', '\App\Http\Controllers\Api\HelpController@getTicket');
    
    Route::get('tags', '\App\Http\Controllers\Api\TagsController@index');
    
    Route::get('zones/countries', '\App\Http\Controllers\Api\ZonesController@getCountries');
    Route::get('zones/counties', '\App\Http\Controllers\Api\ZonesController@getCounties');
    Route::get('zones/sub/roles', '\App\Http\Controllers\Api\SubZoneController@getNatures');
    
    Route::get('zones', '\App\Http\Controllers\Api\ZonesController@index');
    Route::get('zones/{zone}', '\App\Http\Controllers\Api\ZonesController@show');
    
    Route::get('zones/{zone}/sub-zones', '\App\Http\Controllers\Api\SubZoneController@getZoneSubs');
    Route::get('zones/{zone}/sub-zones/{subZone}', '\App\Http\Controllers\Api\SubZoneController@show');
    Route::get('zones/{zone}/sub-zones/{subZone}/listings', '\App\Http\Controllers\Api\SubZoneController@getListings');
    
    Route::get('sub-zones', '\App\Http\Controllers\Api\SubZoneController@index');
    Route::get('counties/{county}/zones', '\App\Http\Controllers\Api\ZonesController@getZonesByCounty');
    
    Route::get('listings/status/{status}', '\App\Http\Controllers\Api\PropertiesController@getPropertiesByStatus');
    Route::get('listings/sub-zone/{sub_zone}', '\App\Http\Controllers\Api\PropertiesController@getPropertiesBySubZone');
    
    Route::get('listings/{property}', '\App\Http\Controllers\Api\PropertiesController@show');
    Route::get('listings/{property}/units', 'App\Http\Controllers\Api\PropertyUnitsController@index');
    Route::get('listings/{property}/units/{unit}', '\App\Http\Controllers\Api\PropertyUnitsController@show');
    
    Route::get('listings/{property}/reviews', 'App\Http\Controllers\Api\PropertyReviewsController@index');
    Route::patch('listings/{property}/reviews', 'App\Http\Controllers\Api\PropertyReviewsController@show');
    
    Route::get('favourites', 'App\Http\Controllers\Api\UserFavouritesController@index');
    Route::get('favourites/category/{model}', 'App\Http\Controllers\Api\UserFavouritesController@indexWithCategory');
    Route::post('favourites', 'App\Http\Controllers\Api\UserFavouritesController@store');
    Route::delete('favourites/{favourite}', 'App\Http\Controllers\Api\UserFavouritesController@destroy');
    
    Route::get('help/faq/{faq}', '\App\Http\Controllers\Api\HelpController@getFaq');
    
    Route::get('chats', '\App\Http\Controllers\Api\ChatsController@index');
    Route::get('chats/{chat}', '\App\Http\Controllers\Api\ChatsController@show');
    Route::delete('chats/{chat}', '\App\Http\Controllers\Api\ChatsController@destroy');
    Route::post('chats/{chat}', '\App\Http\Controllers\Api\ChatsController@storeMessage');
    
    Route::get('notifications', '\App\Http\Controllers\Api\NotificationsController@index');
    Route::get('notifications/unread', '\App\Http\Controllers\Api\NotificationsController@getUnreadNotifications');
    Route::get('notifications/badges', '\App\Http\Controllers\Api\NotificationsController@getBadges');
    Route::patch('notifications/key/{notification}', '\App\Http\Controllers\Api\NotificationsController@setToRead');
    Route::delete('notifications/{model}/{model_id}', '\App\Http\Controllers\Api\NotificationsController@destroy');
    
    Route::get('payment-gateways', '\App\Http\Controllers\Api\TransactionsController@getPaymentGateways');
    
    Route::get('premium/plan/{plan}', '\App\Http\Controllers\Api\PremiumSubscriptionsController@getPremiumPlan');
    
});
