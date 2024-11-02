<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User; // Add this import
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Ticket\Ticketit\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();
        
        /** @var Collection $tickets */
        $tickets = collect([]);

        // check if the ticketit tables exist
        if (DB::getSchemaBuilder()->hasTable('ticketit')) {
            if ($user->ticketit_admin) {
                $tickets = Ticket::latest()->take(5)->get();
            } elseif ($user->ticketit_agent) {
                $tickets = Ticket::where('agent_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();
            }
        }

        return view('user.dashboard', [
            'user' => $user,
            'tickets' => $tickets,
            'isAdmin' => $user->ticketit_admin ?? false,
            'isAgent' => $user->ticketit_agent ?? false
        ]);
    }
}