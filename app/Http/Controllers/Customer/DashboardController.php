<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Ticket\Ticketit\Models\Ticket;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer.auth');
    }

    public function index()
    {
        $customer = Auth::guard('customer')->user();
        
        
        $tickets = Ticket::where('customer_id', $customer->id)
                        ->with(['status'])
                        ->latest()
                        ->take(5)
                        ->get();

        return view('customer.dashboard', compact('customer', 'tickets'));
    }
}