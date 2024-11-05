<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Auth::routes();

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('user.dashboard');
    }
    if(Auth::guard('customer')->check()){
        return redirect()->route('customer.dashboard');
    }
    
    return view('welcome');
});

// User/Staff Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', 'User\DashboardController@index')->name('user.dashboard');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});

// Customer Routes
Route::group(['prefix' => 'customer'], function () {
    // Auth Routes
    Route::get('login', 'Auth\Customer\LoginController@showLoginForm')->name('customer.login');
    Route::post('login', 'Auth\Customer\LoginController@login');
    Route::post('logout', 'Auth\Customer\LoginController@logout')->name('customer.logout');
    Route::get('register', 'Auth\Customer\RegisterController@showRegistrationForm')->name('customer.register');
    Route::post('register', 'Auth\Customer\RegisterController@register');
    
    // Protected Customer Routes
    Route::group(['middleware' => 'customer.auth'], function () {
        Route::get('dashboard', 'Customer\DashboardController@index')->name('customer.dashboard');
    });
});


Route::get('/home', function() {
    return redirect()->route('user.dashboard');
})->name('home');

// Ticketit Routes
if (file_exists(base_path('routes/ticketit/routes.php'))) {
    require base_path('routes/ticketit/routes.php');
}