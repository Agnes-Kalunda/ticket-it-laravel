<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || (!auth()->user()->ticketit_admin && !auth()->user()->ticketit_agent)) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Only staff members can access this area.');
        }

        return $next($request);
    }
}