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

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', '\App\Http\Controllers\Api\UserController@getAuthenticatedUser');
    Route::get('user/account', '\App\Http\Controllers\Api\UserController@getAuthenticatedUserAccount');
    Route::post('user/account', '\App\Http\Controllers\Api\UserController@updateAccount');
    Route::post('user/avatar', '\App\Http\Controllers\Api\UserController@updateAvatar');
    Route::delete('user/avatar', '\App\Http\Controllers\Api\UserController@removeAvatar');
    Route::post('user/secret', '\App\Http\Controllers\Api\UserController@updatePassword');

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
    Route::delete('zones/{zone}/sub-zones/{subZone}', '\App\Http\Controllers\Api\SubZoneController@destroySubZone');

    Route::get('sub-zones', '\App\Http\Controllers\Api\SubZoneController@index');
});
