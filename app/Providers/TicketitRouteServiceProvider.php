<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class TicketitRouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (file_exists(base_path('routes/ticketit.php'))) {
            Route::middleware('web')
                ->group(base_path('routes/ticketit.php'));
        }
    }

    public function register()
    {
        //
    }
}