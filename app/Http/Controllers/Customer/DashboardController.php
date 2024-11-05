<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $user = Auth::user();
            Log::info('User loaded:', [
                'id' => $user->id,
                'name' => $user->name,
                'isAdmin' => $user->ticketit_admin,
                'isAgent' => $user->ticketit_agent
            ]);

            $tickets = collect([]);

            if ($user->ticketit_admin) {
                Log::info('Fetching tickets for admin');
                try {
                    $tickets = DB::table('ticketit')
                        ->join('ticketit_statuses', 'ticketit.status_id', '=', 'ticketit_statuses.id')
                        ->join('ticketit_priorities', 'ticketit.priority_id', '=', 'ticketit_priorities.id')
                        ->join('ticketit_categories', 'ticketit.category_id', '=', 'ticketit_categories.id')
                        ->join('customers', 'ticketit.customer_id', '=', 'customers.id')
                        ->select([
                            'ticketit.*',
                            'ticketit_statuses.name as status_name',
                            'ticketit_statuses.color as status_color',
                            'ticketit_priorities.name as priority_name',
                            'ticketit_priorities.color as priority_color',
                            'ticketit_categories.name as category_name',
                            'customers.name as customer_name'
                        ])
                        ->orderBy('ticketit.created_at', 'desc')
                        ->get();

                    Log::info('Admin tickets fetched:', [
                        'count' => $tickets->count(),
                        'sql' => DB::getQueryLog()
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error fetching admin tickets: ' . $e->getMessage(), [
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } elseif ($user->ticketit_agent) {
                Log::info('Fetching tickets for agent:', ['agent_id' => $user->id]);
                try {
                    $tickets = DB::table('ticketit')
                        ->where('agent_id', $user->id)
                        ->join('ticketit_statuses', 'ticketit.status_id', '=', 'ticketit_statuses.id')
                        ->join('ticketit_priorities', 'ticketit.priority_id', '=', 'ticketit_priorities.id')
                        ->join('ticketit_categories', 'ticketit.category_id', '=', 'ticketit_categories.id')
                        ->join('customers', 'ticketit.customer_id', '=', 'customers.id')
                        ->select([
                            'ticketit.*',
                            'ticketit_statuses.name as status_name',
                            'ticketit_statuses.color as status_color',
                            'ticketit_priorities.name as priority_name',
                            'ticketit_priorities.color as priority_color',
                            'ticketit_categories.name as category_name',
                            'customers.name as customer_name'
                        ])
                        ->orderBy('ticketit.created_at', 'desc')
                        ->get();

                    Log::info('Agent tickets fetched:', [
                        'count' => $tickets->count(),
                        'sql' => DB::getQueryLog()
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error fetching agent tickets: ' . $e->getMessage(), [
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            } else {
                Log::info('User is neither admin nor agent');
            }

            // Debug database tables
            Log::info('Database table info:', [
                'ticketit_exists' => Schema::hasTable('ticketit'),
                'statuses_exists' => Schema::hasTable('ticketit_statuses'),
                'priorities_exists' => Schema::hasTable('ticketit_priorities'),
                'categories_exists' => Schema::hasTable('ticketit_categories'),
                'ticketit_count' => DB::table('ticketit')->count(),
                'statuses_count' => DB::table('ticketit_statuses')->count(),
                'priorities_count' => DB::table('ticketit_priorities')->count(),
                'categories_count' => DB::table('ticketit_categories')->count(),
            ]);

            // Debug ticket data
            if ($tickets->count() > 0) {
                Log::info('First ticket data:', [
                    'ticket' => $tickets->first()
                ]);
            }

            return view('user.dashboard', [
                'user' => $user,
                'tickets' => $tickets,
                'isAdmin' => $user->ticketit_admin,
                'isAgent' => $user->ticketit_agent
            ]);

        } catch (\Exception $e) {
            Log::error('Dashboard controller error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('user.dashboard', [
                'user' => Auth::user(),
                'tickets' => collect([]),
                'isAdmin' => false,
                'isAgent' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}