// resources/views/user/dashboard.blade.php

@extends('layouts.app')

@section('styles')
<style>
.card {
    border-radius: 0.5rem;
}
.badge {
    padding: 0.5em 1em;
    font-weight: 500;
}
.badge.bg-low { background-color: #28a745; color: white; }
.badge.bg-medium { background-color: #ffc107; color: black; }
.badge.bg-high { background-color: #dc3545; color: white; }
.badge.bg-open { background-color: #17a2b8; color: white; }
.badge.bg-pending { background-color: #ffc107; color: black; }
.badge.bg-resolved { background-color: #28a745; color: white; }
.badge.bg-closed { background-color: #6c757d; color: white; }
.unassigned { background-color: #ffc107; font-style: italic; }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $isAdmin ? 'Admin' : 'Agent' }} Dashboard</h5>
                </div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4 class="mb-4">Welcome, {{ $user->name }}!</h4>
                    
                    @if($isAdmin)
                        <!-- Admin Stats -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-primary text-white rounded">
                                        <h6 class="text-uppercase">Total Tickets</h6>
                                        <h2 class="mb-0">{{ $stats['total'] }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-warning text-dark rounded">
                                        <h6 class="text-uppercase">Unassigned</h6>
                                        <h2 class="mb-0">{{ $stats['unassigned'] }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-info text-white rounded">
                                        <h6 class="text-uppercase">Open</h6>
                                        <h2 class="mb-0">{{ $stats['open'] }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-danger text-white rounded">
                                        <h6 class="text-uppercase">High Priority</h6>
                                        <h2 class="mb-0">{{ $stats['high_priority'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Available Agents Card -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Support Agents</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($availableAgents as $agent)
                                        <div class="col-md-4 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>{{ $agent->name }}</h6>
                                                    <small class="text-muted">{{ $agent->email }}</small>
                                                    <div class="mt-2 text-muted">
                                                        Assigned tickets: {{ $agent->assigned_tickets_count }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Agent Stats -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-primary text-white rounded">
                                        <h6 class="text-uppercase">My Assigned Tickets</h6>
                                        <h2 class="mb-0">{{ $stats['assigned'] }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-info text-white rounded">
                                        <h6 class="text-uppercase">Open</h6>
                                        <h2 class="mb-0">{{ $stats['my_open'] }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-warning text-dark rounded">
                                        <h6 class="text-uppercase">Pending</h6>
                                        <h2 class="mb-0">{{ $stats['my_pending'] }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Tickets Table -->
                    @if($tickets->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    {{ $isAdmin ? 'Recent Tickets' : 'My Assigned Tickets' }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Customer</th>
                                                <th>Subject</th>
                                                <th>Priority</th>
                                                <th>Status</th>
                                                @if($isAdmin)
                                                    <th>Agent</th>
                                                @endif
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->id }}</td>
                                                <td>
                                                    {{ $ticket->customer_name }}<br>
                                                    <small class="text-muted">{{ $ticket->customer_email }}</small>
                                                </td>
                                                <td>
                                                    <a href="{{ route('staff.tickets.show', $ticket->id) }}">
                                                        {{ $ticket->subject }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $ticket->priority_color }}">
                                                        {{ $ticket->priority_name }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $ticket->status_color }}">
                                                        {{ $ticket->status_name }}
                                                    </span>
                                                </td>
                                                @if($isAdmin)
                                                    <td>
                                                        @if($ticket->agent_name)
                                                            {{ $ticket->agent_name }}
                                                        @else
                                                            <span class="badge unassigned">Unassigned</span>
                                                        @endif
                                                    </td>
                                                @endif
                                                <td>{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="{{ route('staff.tickets.show', $ticket->id) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            View
                                                        </a>
                                                        @if($isAdmin && !$ticket->agent_id)
                                                            <a href="{{ route('staff.tickets.show', $ticket->id) }}" 
                                                               class="btn btn-sm btn-success">
                                                                Assign
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No tickets found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection