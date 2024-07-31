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
Route::post('forgot-password', '\App\Http\Controllers\AuthController@forgotPassword');
Route::get('/reset-password/{token}', function (string $token) {
    return view('app', ['token' => $token]);
})->middleware('guest')->name('password.reset');
Route::post('reset-password', '\App\Http\Controllers\AuthController@resetPassword');

// Route::view('/', 'app');

Route::view('/{any?}', 'app')
    ->name('app')
    ->where('any', '.*');
