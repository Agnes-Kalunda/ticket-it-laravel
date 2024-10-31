<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// user authentication routes
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// customer auth routes
Route::get('customer/login', 'Auth\CustomerLoginController@showLoginForm')->name('customer.login');
Route::post('customer/login', 'Auth\CustomerLoginController@login');


// dashboard routes
Route::get('/dashboard', 'UserDashboardController@index')->name('user.dashboard')->middleware('auth');
Route::get('/customer/dashboard', 'CustomerDashboardController@index')->name('customer.dashboard')->middleware('auth:customer');
