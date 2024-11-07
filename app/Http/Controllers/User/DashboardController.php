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
                ->leftJoin('users as agents', 'ticketit.agent_id', '=', 'agents.id')
                ->select([
                    'ticketit.*',
                    'ticketit_statuses.name as status_name',
                    'ticketit_statuses.color as status_color',
                    'ticketit_priorities.name as priority_name',
                    'ticketit_priorities.color as priority_color',
                    'ticketit_categories.name as category_name',
                    'customers.name as customer_name',
                    'customers.email as customer_email',
                    'agents.name as agent_name'
                ]);

            // If user is agent but not admin, only show their tickets
            if ($user->ticketit_agent && !$user->ticketit_admin) {
                $query->where('agent_id', $user->id);
            }

            $tickets = $query->orderBy('ticketit.created_at', 'desc')->get();

            // Get available agents for admin
            $availableAgents = [];
            if ($user->ticketit_admin) {
                $availableAgents = User::where('ticketit_agent', true)
                    ->select('id', 'name', 'email')
                    ->withCount(['assignedTickets' => function($query) {
                        $query->whereNull('completed_at');
                    }])
                    ->get();
            }

            // Calculate appropriate stats based on role
            $stats = $user->ticketit_admin ? 
                $this->getAdminStats($tickets) : 
                $this->getAgentStats($tickets);

            return view('user.dashboard', [
                'user' => $user,
                'tickets' => $tickets,
                'stats' => $stats,
                'isAdmin' => $user->ticketit_admin,
                'isAgent' => $user->ticketit_agent,
                'availableAgents' => $availableAgents ?? collect([])
            ]);
        }

        // Regular user view
        return view('user.dashboard', [
            'user' => $user
        ]);

    } catch (\Exception $e) {
        Log::error('Error in dashboard:', [
            'error' => $e->getMessage(),
            'user_id' => $user->id
        ]);

        return view('user.dashboard', [
            'user' => $user,
            'error' => 'Error loading dashboard. Please try again.'
        ]);
    }
}

protected function getAdminStats($tickets)
{
    return [
        'total' => $tickets->count(),
        'unassigned' => $tickets->whereNull('agent_id')->count(),
        'open' => $tickets->where('status_id', 1)->count(),
        'pending' => $tickets->where('status_id', 2)->count(),
        'high_priority' => $tickets->where('priority_id', 3)->count()
    ];
}

protected function getAgentStats($tickets)
{
    return [
        'assigned' => $tickets->count(),
        'my_open' => $tickets->where('status_id', 1)->count(),
        'my_pending' => $tickets->where('status_id', 2)->count()
    ];
}
}