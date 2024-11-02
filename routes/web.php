<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Ticket\Ticketit\Models\Setting;

// Default settings without DB dependency
$settings = [
    'main_route' => 'tickets',
    'main_route_path' => 'tickets',
    'admin_route' => 'tickets-admin',
    'admin_route_path' => 'tickets-admin'
];

// Only try to get DB settings if table exists
if (Schema::hasTable('ticketit_settings')) {
    try {
        $settings = [
            'main_route' => Setting::grab('main_route') ?: 'tickets',
            'main_route_path' => Setting::grab('main_route_path') ?: 'tickets',
            'admin_route' => Setting::grab('admin_route') ?: 'tickets-admin',
            'admin_route_path' => Setting::grab('admin_route_path') ?: 'tickets-admin'
        ];
    } catch (\Exception $e) {
        // Keep using default settings if there's any error
    }
}

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

// User/Staff Routes with Ticketit Integration
Route::middleware('auth')->group(function () use ($settings) {
    // Dashboard
    Route::get('/dashboard', 'User\DashboardController@index')->name('user.dashboard');

    if (Schema::hasTable('ticketit_settings')) {
        // Staff Ticket Routes
        Route::prefix($settings['main_route_path'])->group(function () use ($settings) {
            Route::get('/', 'Ticket\Ticketit\Controllers\TicketsController@index')
                ->name($settings['main_route'].'.index');
                
            Route::get('/complete', 'Ticket\Ticketit\Controllers\TicketsController@indexComplete')
                ->name($settings['main_route'].'-complete');
                
            Route::get('/data/{id?}', 'Ticket\Ticketit\Controllers\TicketsController@data')
                ->name($settings['main_route'].'.data');
                
            Route::get('/{ticket}', 'Ticket\Ticketit\Controllers\TicketsController@show')
                ->name($settings['main_route'].'.show');
                
            Route::put('/{ticket}', 'Ticket\Ticketit\Controllers\TicketsController@update')
                ->name($settings['main_route'].'.update');
                
            Route::get('/{ticket}/complete', 'Ticket\Ticketit\Controllers\TicketsController@complete')
                ->name($settings['main_route'].'.complete');
                
            Route::get('/{ticket}/reopen', 'Ticket\Ticketit\Controllers\TicketsController@reopen')
                ->name($settings['main_route'].'.reopen');
        });

        // Comments Routes
        Route::resource($settings['main_route_path'].'-comment', 'Ticket\Ticketit\Controllers\CommentsController', [
            'names' => [
                'store' => $settings['main_route'].'-comment.store'
            ]
        ])->only(['store']);

        // Admin Routes
        Route::middleware('Ticket\Ticketit\Middleware\IsAdminMiddleware')
            ->prefix($settings['admin_route_path'])
            ->group(function () use ($settings) {
                Route::get('/', 'Ticket\Ticketit\Controllers\DashboardController@index');
                Route::get('/indicator/{indicator_period?}', 'Ticket\Ticketit\Controllers\DashboardController@index')
                    ->name($settings['admin_route'].'.dashboard.indicator');
                    
                // Admin Resources
                foreach(['status', 'priority', 'category', 'agent', 'administrator'] as $resource) {
                    Route::resource($resource, "Ticket\Ticketit\Controllers\\".ucfirst($resource).'sController', [
                        'names' => [
                            'index' => "{$settings['admin_route']}.{$resource}.index",
                            'create' => "{$settings['admin_route']}.{$resource}.create",
                            'store' => "{$settings['admin_route']}.{$resource}.store",
                            'show' => "{$settings['admin_route']}.{$resource}.show",
                            'edit' => "{$settings['admin_route']}.{$resource}.edit",
                            'update' => "{$settings['admin_route']}.{$resource}.update",
                            'destroy' => "{$settings['admin_route']}.{$resource}.destroy",
                        ]
                    ]);
                }
        });
    }
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
        // Dashboard
        Route::get('dashboard', 'Customer\DashboardController@index')->name('customer.dashboard');
        
        // Customer Ticket Routes - Use full namespace
        Route::group(['prefix' => 'tickets'], function () {
            Route::get('/', [
                'as' => 'customer.tickets.index',
                'uses' => '\Ticket\Ticketit\Controllers\TicketsController@customerIndex'
            ]);
            
            Route::get('/create', [
                'as' => 'customer.tickets.create',
                'uses' => '\Ticket\Ticketit\Controllers\TicketsController@create'
            ]);
            
            Route::post('/', [
                'as' => 'customer.tickets.store',
                'uses' => '\Ticket\Ticketit\Controllers\TicketsController@store'
            ]);
            
            Route::get('/{ticket}', [
                'as' => 'customer.tickets.show',
                'uses' => '\Ticket\Ticketit\Controllers\TicketsController@show'
            ]);
        });
    });
});

// redirect home
Route::get('/home', function() {
    return redirect()->route('user.dashboard');
})->name('home');