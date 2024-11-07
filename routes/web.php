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
    // Dashboard
    Route::get('/dashboard', 'User\DashboardController@index')->name('user.dashboard');
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    // Admin Routes
    Route::middleware('admin')->group(function() {
        // User Management
        Route::resource('users', 'UsersController');
        
        // Ticket Management for Admins
        Route::prefix('admin/tickets')->name('admin.tickets.')->group(function() {
            Route::get('/', 'TicketsController@adminIndex')->name('index');
            Route::get('/{ticket}', 'TicketsController@adminShow')->name('show');
            Route::post('/{ticket}/assign', 'TicketsController@assignAgent')->name('assign');
            Route::get('/stats', 'TicketsController@adminStats')->name('stats');
        });
    });

    // Agent Routes
    Route::middleware('agent')->group(function() {
        Route::prefix('agent/tickets')->name('agent.tickets.')->group(function() {
            Route::get('/', 'TicketsController@agentIndex')->name('index');
            Route::get('/{ticket}', 'TicketsController@agentShow')->name('show');
            Route::post('/{ticket}/status', 'TicketsController@updateStatus')->name('status.update');
            Route::post('/{ticket}/comment', 'TicketsController@addComment')->name('comment');
        });
    });

    // Shared Staff Routes (Admin & Agent)
    Route::middleware('staff')->group(function() {
        Route::prefix('staff/tickets')->name('staff.tickets.')->group(function() {
            Route::get('/', 'TicketsController@staffIndex')->name('index');
            Route::get('/{ticket}', 'TicketsController@staffShow')->name('show');
            
            // Comments
            Route::post('/{ticket}/comments', 'CommentsController@store')->name('comments.store');
            Route::put('/comments/{comment}', 'CommentsController@update')->name('comments.update');
            Route::delete('/comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');
            
            // Status Updates
            Route::post('/{ticket}/status', 'TicketsController@updateStatus')->name('status.update');
            
            // Agent Assignment
            Route::post('/{ticket}/assign', 'TicketsController@assignTicket')->name('assign');
        });
    });
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
        
        // Tickets
        Route::prefix('tickets')->name('customer.tickets.')->group(function() {
            Route::get('/', 'TicketsController@index')->name('index');
            Route::get('/create', 'TicketsController@create')->name('create');
            Route::post('/', 'TicketsController@store')->name('store');
            Route::get('/{ticket}', 'TicketsController@show')->name('show');
            
            // Comments
            Route::post('/{ticket}/comments', 'CommentsController@store')->name('comments.store');
            Route::put('/comments/{comment}', 'CommentsController@update')->name('comments.update');
            Route::delete('/comments/{comment}', 'CommentsController@destroy')->name('comments.destroy');
        });
    });
});

Route::get('/home', function() {
    return redirect()->route('user.dashboard');
})->name('home');

// Custom Middleware Group Definitions
Route::middleware(['auth', 'staff'])->group(function() {
    // Ticket Categories
    Route::resource('categories', 'CategoriesController')->except(['show']);
    
    // Ticket Priorities
    Route::resource('priorities', 'PrioritiesController')->except(['show']);
    
    // Ticket Statuses
    Route::resource('statuses', 'StatusesController')->except(['show']);
});

// Ticketit Package Routes
if (file_exists(base_path('routes/ticketit.php'))) {
    require base_path('routes/ticketit.php');
}

// Helper Routes
Route::get('download/{file}', 'TicketsController@download')
    ->name('tickets.download')
    ->middleware('auth');

// API Routes for AJAX Requests
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function() {
    Route::get('tickets/stats', 'Api\TicketsController@stats')->name('tickets.stats');
    Route::get('tickets/search', 'Api\TicketsController@search')->name('tickets.search');
});