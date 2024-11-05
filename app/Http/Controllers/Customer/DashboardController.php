<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Customer;
use Illuminate\Http\Request;
use Ticket\Ticketit\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('customer.auth');
    }

    public function index()
    {
        /** @var Customer $customer */
        $customer = auth('customer')->user();
        $tickets = collect([]); // init empty collection

        // check if ticketit table exists
        if (DB::getSchemaBuilder()->hasTable('ticketit')) {
            $tickets = Ticket::where('customer_id', $customer->id)
                           ->latest()
                           ->take(5)
                           ->get();
        }

        return view('customer.dashboard', compact('customer', 'tickets'));
    }
}