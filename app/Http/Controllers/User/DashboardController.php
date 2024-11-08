<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
{
    $user = Auth::user();
    $tickets = collect([]);

    try {
        if ($user->ticketit_admin || $user->ticketit_agent) {
            $query = DB::table('ticketit')
                ->leftJoin('ticketit_statuses', 'ticketit.status_id', '=', 'ticketit_statuses.id')
                ->leftJoin('ticketit_priorities', 'ticketit.priority_id', '=', 'ticketit_priorities.id')
                ->leftJoin('ticketit_categories', 'ticketit.category_id', '=', 'ticketit_categories.id')
                ->leftJoin('customers', 'ticketit.customer_id', '=', 'customers.id')
                ->select([
                    'ticketit.*',
                    'ticketit_statuses.name as status_name',
                    'ticketit_statuses.color as status_color',
                    'ticketit_priorities.name as priority_name',
                    'ticketit_priorities.color as priority_color',
                    'ticketit_categories.name as category_name',
                    'customers.name as customer_name'
                ]);

            // If user is an agent but not admin, only show their tickets
            if ($user->ticketit_agent && !$user->ticketit_admin) {
                $query->where('agent_id', $user->id);
            }

            $tickets = $query->orderBy('ticketit.created_at', 'desc')->get();

            $stats = [
                'total' => $tickets->count(),
                'open' => $tickets->where('status_id', 1)->count(),
                'pending' => $tickets->where('status_id', 2)->count(),
                'resolved' => $tickets->where('status_id', 3)->count(),
                'high_priority' => $tickets->where('priority_id', 3)->count()
            ];
        }

        return view('user.dashboard', [
            'user' => $user,
            'tickets' => $tickets,
            'stats' => $stats ?? [
                'total' => 0,
                'open' => 0,
                'pending' => 0,
                'resolved' => 0,
                'high_priority' => 0
            ],
            'isAdmin' => $user->ticketit_admin,
            'isAgent' => $user->ticketit_agent
        ]);

    } catch (\Exception $e) {
        Log::error('Error in dashboard:', [
            'error' => $e->getMessage(),
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('error', 'Error loading dashboard.');
    }
}}