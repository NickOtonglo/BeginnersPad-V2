<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('app');
// });

Route::post('sign-in', '\App\Http\Controllers\AuthController@login')->name('login');
Route::post('sign-out', '\App\Http\Controllers\AuthController@logout')->middleware(['auth:sanctum'])->name('logout');
Route::post('sign-up', '\App\Http\Controllers\AuthController@register');

// Route::view('/', 'app');

Route::view('/{any?}', 'app')
    ->name('app')
    ->where('any', '.*');
