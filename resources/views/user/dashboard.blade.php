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
.table td { vertical-align: middle; }
.btn-outline-primary { padding: 0.25rem 0.75rem; }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Staff Dashboard</h5>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4 class="mb-4">Welcome, {{ $user->name }}!</h4>
                    
                    @if($isAdmin || $isAgent)
                        <!-- Stats Cards -->
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
                                    <div class="card-body bg-info text-white rounded">
                                        <h6 class="text-uppercase">Open</h6>
                                        <h2 class="mb-0">{{ $stats['open'] }}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body bg-warning text-white rounded">
                                        <h6 class="text-uppercase">Pending</h6>
                                        <h2 class="mb-0">{{ $stats['pending'] }}</h2>
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

                        @if($tickets->count() > 0)
                            <div class="card shadow-sm">
                                <div class="card-header bg-white">
                                    <h5 class="mb-0">Recent Tickets</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Customer</th>
                                                    <th>Subject</th>
                                                    <th>Priority</th>
                                                    <th>Status</th>
                                                    <th>Created</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($tickets as $ticket)
                                                <tr>
                                                    <td>{{ $ticket->id }}</td>
                                                    <td>{{ $ticket->customer_name ?? 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('staff.tickets.show', $ticket->id) }}">
                                                            {{ $ticket->subject }}
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge">{{ $ticket->priority_name }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $ticket->status_color }}">
                                                            {{ $ticket->status_name }}
                                                        </span>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</td>
                                                    <td>
                                                                        @if($isAgent)
                                                                            <a href="{{ route('staff.tickets.agent.show', $ticket->id) }}" 
                                                                            class="btn btn-sm btn-primary">
                                                                            View
                                                                            </a>
                                                                        @else
                                                                            <a href="{{ route('staff.tickets.show', $ticket->id) }}" 
                                                                            class="btn btn-sm btn-primary">
                                                                            View
                                                                            </a>
                                                                        @endif
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
                    @else
                        <div class="alert alert-warning">
                            You do not have permission to view tickets.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@php
function getStatusName($statusId) {
    $statuses = [
        1 => 'Open',
        2 => 'Pending',
        3 => 'Resolved',
        4 => 'Closed'
    ];
    return $statuses[$statusId] ?? 'Unknown';
}

function getStatusClass($statusId) {
    $classes = [
        1 => 'bg-open',
        2 => 'bg-pending',
        3 => 'bg-resolved',
        4 => 'bg-closed'
    ];
    return $classes[$statusId] ?? 'bg-secondary';
}
@endphp