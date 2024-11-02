<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ticket\Ticketit\Models\Ticket;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer.auth');
    }

    public function index()
    {
        $customer = auth('customer')->user();
        $tickets = $customer->tickets()->latest()->take(5)->get();

        return view('customer.dashboard', compact('customer', 'tickets'));
    }
}