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
// user routes
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

// customer Routes
Route::group(['prefix' => 'customer'], function () {
    Route::get('login', 'Auth\Customer\LoginController@showLoginForm')->name('customer.login');
    Route::post('login', 'Auth\Customer\LoginController@login');
    Route::post('logout', 'Auth\Customer\LoginController@logout')->name('customer.logout');
    Route::get('register', 'Auth\Customer\RegisterController@showRegistrationForm')->name('customer.register');
    Route::post('register', 'Auth\Customer\RegisterController@register');
    
    // proected customer Routes
    Route::group(['middleware' => 'customer.auth'], function () {
        Route::get('dashboard', 'Customer\DashboardController@index')->name('customer.dashboard');
    });
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
