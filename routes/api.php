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

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', '\App\Http\Controllers\Api\UserController@getAuthenticatedUser');
    Route::get('/user/account', '\App\Http\Controllers\Api\UserController@getAuthenticatedUserAccount');
    Route::post('/user/account', '\App\Http\Controllers\Api\UserController@updateAccount');
    Route::post('/user/secret', '\App\Http\Controllers\Api\UserController@updatePassword');
});
