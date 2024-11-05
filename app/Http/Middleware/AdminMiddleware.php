<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->ticketit_admin) {
            return redirect()->route('user.dashboard')
                ->with('error', 'You do not have permission to access that area.');
        }

        return $next($request);
    }
}