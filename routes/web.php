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

Route::post('sign-in', '\App\Http\Controllers\AuthController@login')->name('auth.login');
Route::post('sign-out', '\App\Http\Controllers\AuthController@logout')->middleware(['auth:sanctum'])->name('auth.logout');

// Route::view('/', 'app');

Route::view('/{any?}', 'app')
    ->name('app')
    ->where('any', '.*');
