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

Route::get('/articles', '\App\Http\Controllers\Api\ArticlesController@index');
Route::get('/articles/{article}', '\App\Http\Controllers\Api\ArticlesController@show');

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', '\App\Http\Controllers\Api\UserController@getAuthenticatedUser');
    Route::get('/user/account', '\App\Http\Controllers\Api\UserController@getAuthenticatedUserAccount');
    Route::post('/user/account', '\App\Http\Controllers\Api\UserController@updateAccount');
    Route::post('/user/avatar', '\App\Http\Controllers\Api\UserController@updateAvatar');
    Route::delete('/user/avatar', '\App\Http\Controllers\Api\UserController@removeAvatar');
    Route::post('/user/secret', '\App\Http\Controllers\Api\UserController@updatePassword');
    
    Route::post('/articles', '\App\Http\Controllers\Api\ArticlesController@store');
    
    Route::get('tags', '\App\Http\Controllers\Api\TagsController@index');
});
