<?php

use Illuminate\Http\Request;
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

Route::get('articles', '\App\Http\Controllers\Api\ArticlesController@index');
Route::get('articles/{article}', '\App\Http\Controllers\Api\ArticlesController@show');
Route::get('articles/{article}/author', '\App\Http\Controllers\Api\ArticlesController@getAuthorName');

Route::get('articles/{article}/tags', '\App\Http\Controllers\Api\ArticlesController@getTags');
Route::get('tags/{tag}', '\App\Http\Controllers\Api\TagsController@show');
Route::get('tags/{tag}/articles', '\App\Http\Controllers\Api\TagsController@getArticles');

Route::get('listings/home', '\App\Http\Controllers\Api\PropertiesController@indexHome');
Route::get('listings', '\App\Http\Controllers\Api\PropertiesController@index');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', '\App\Http\Controllers\Api\UserController@getAuthenticatedUser');
    Route::get('user/account', '\App\Http\Controllers\Api\UserController@getAuthenticatedUserAccount');
    Route::post('user/account', '\App\Http\Controllers\Api\UserController@updateAccount');
    Route::post('user/avatar', '\App\Http\Controllers\Api\UserController@updateAvatar');
    Route::delete('user/avatar', '\App\Http\Controllers\Api\UserController@removeAvatar');
    Route::post('user/secret', '\App\Http\Controllers\Api\UserController@updatePassword');

    Route::post('brand/avatar', '\App\Http\Controllers\Api\UserController@updateBrandAvatar');
    Route::delete('brand/avatar', '\App\Http\Controllers\Api\UserController@removeBrandAvatar');
    Route::patch('brand', '\App\Http\Controllers\Api\UserController@updateBrand');
    Route::post('brand', '\App\Http\Controllers\Api\UserController@saveBrand');

    Route::post('articles', '\App\Http\Controllers\Api\ArticlesController@store');
    Route::patch('articles/{article}/edit', '\App\Http\Controllers\Api\ArticlesController@update');
    Route::delete('articles/{article}', '\App\Http\Controllers\Api\ArticlesController@destroy');

    Route::get('tags', '\App\Http\Controllers\Api\TagsController@index');
    Route::post('tags', '\App\Http\Controllers\Api\TagsController@store');
    Route::patch('tags/{id}', '\App\Http\Controllers\Api\TagsController@update');
    Route::delete('tags/{tag}', '\App\Http\Controllers\Api\TagsController@destroy');
    
    Route::get('zones/countries', '\App\Http\Controllers\Api\ZonesController@getCountries');
    Route::get('zones/counties', '\App\Http\Controllers\Api\ZonesController@getCounties');
    Route::get('zones/sub/roles', '\App\Http\Controllers\Api\SubZoneController@getNatures');

    Route::get('zones', '\App\Http\Controllers\Api\ZonesController@index');
    Route::post('zones', '\App\Http\Controllers\Api\ZonesController@store');
    Route::get('zones/{zone}', '\App\Http\Controllers\Api\ZonesController@show');
    Route::patch('zones/{zone}', '\App\Http\Controllers\Api\ZonesController@update');
    Route::delete('zones/{zone}', '\App\Http\Controllers\Api\ZonesController@destroy');
    
    Route::get('zones/{zone}/sub-zones', '\App\Http\Controllers\Api\SubZoneController@getZoneSubs');
    Route::post('zones/{zone}/sub-zones', '\App\Http\Controllers\Api\SubZoneController@store');
    Route::get('zones/{zone}/sub-zones/{subZone}', '\App\Http\Controllers\Api\SubZoneController@show');
    Route::patch('zones/{zone}/sub-zones/{subZone}', '\App\Http\Controllers\Api\SubZoneController@update');
    Route::delete('zones/{zone}/sub-zones/{subZone}', '\App\Http\Controllers\Api\SubZoneController@destroy');

    Route::get('sub-zones', '\App\Http\Controllers\Api\SubZoneController@index');

    Route::get('listings/my-listings', '\App\Http\Controllers\Api\PropertiesController@getMyListings');
    Route::get('listings/my-listings/{property}', '\App\Http\Controllers\Api\PropertiesController@showMyListing');
    Route::post('listings', '\App\Http\Controllers\Api\PropertiesController@store');
    Route::get('listings/{property}', '\App\Http\Controllers\Api\PropertiesController@show');
    Route::patch('listings/{property}', '\App\Http\Controllers\Api\PropertiesController@update');
    Route::delete('listings/{property}', '\App\Http\Controllers\Api\PropertiesController@destroy');
    Route::post('listings/{property}/features', '\App\Http\Controllers\Api\PropertiesController@storeFeatures');
    Route::delete('listings/{property}/features/{feature}', '\App\Http\Controllers\Api\PropertiesController@destroyFeature');
    Route::post('listings/{property}/files', '\App\Http\Controllers\Api\PropertiesController@storeFiles');
    Route::delete('listings/{property}/files/{file}', '\App\Http\Controllers\Api\PropertiesController@destroyFile');
    Route::post('listings/{property}/thumbnail', '\App\Http\Controllers\Api\PropertiesController@updateThumbnail');

    Route::get('listings/{property}/units', 'App\Http\Controllers\Api\PropertyUnitsController@index');
    Route::post('listings/{property}', 'App\Http\Controllers\Api\PropertyUnitsController@store');
    Route::get('listings/{property}/units/{unit}', '\App\Http\Controllers\Api\PropertyUnitsController@show');
    Route::patch('listings/{property}/units/{unit}', 'App\Http\Controllers\Api\PropertyUnitsController@update');
    Route::delete('listings/{property}/units/{unit}', 'App\Http\Controllers\Api\PropertyUnitsController@destroy');
    Route::post('listings/{property}/units/{unit}/features', 'App\Http\Controllers\Api\PropertyUnitsController@storeFeatures');
    Route::delete('listings/{property}/units/{unit}/features/{feature}', '\App\Http\Controllers\Api\PropertyUnitsController@destroyFeature');
    Route::post('listings/{property}/units/{unit}/files', '\App\Http\Controllers\Api\PropertyUnitsController@storeFiles');
    Route::delete('listings/{property}/units/{unit}/files/{file}', '\App\Http\Controllers\Api\PropertyUnitsController@destroyFile');
    Route::post('listings/{property}/units/{unit}/thumbnail', '\App\Http\Controllers\Api\PropertyUnitsController@updateThumbnail');
    Route::patch('listings/{property}/units/{unit}/disclaimer', '\App\Http\Controllers\Api\PropertyUnitsController@storeDisclaimer');

    Route::get('listings/{property}/reviews', 'App\Http\Controllers\Api\PropertyReviewsController@index');
    Route::post('listings/{property}/reviews', 'App\Http\Controllers\Api\PropertyReviewsController@store');
    Route::patch('listings/{property}/reviews', 'App\Http\Controllers\Api\PropertyReviewsController@show');
    Route::patch('listings/{property}/reviews/{review}', 'App\Http\Controllers\Api\PropertyReviewsController@update');
    Route::delete('listings/{property}/reviews/{review}', 'App\Http\Controllers\Api\PropertyReviewsController@destroy');

    Route::get('favourites', 'App\Http\Controllers\Api\UserFavouritesController@index');
    Route::post('favourites', 'App\Http\Controllers\Api\UserFavouritesController@store');
    Route::delete('favourites/{favourite}', 'App\Http\Controllers\Api\UserFavouritesController@destroy');
});
