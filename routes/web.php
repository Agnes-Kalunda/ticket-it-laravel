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
    if(Auth::check()){
        return redirect()->route('user.dashboard');
    }
    if(Auth::guard('customer')->check()){
        return redirect()->route('customer.dashboard');
    }
    
    return view('welcome');
});
// user routes - login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


// user dashboard routes
Route::get('/dashboard', 'User\DashboardController@index')->name('user.dashboard')->middleware('auth');

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

// redirect home
Route::get('/home', function() {
    return redirect()->route('user.dashboard');
})->name('home');