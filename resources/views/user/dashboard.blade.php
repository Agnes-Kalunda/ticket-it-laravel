@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Staff Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (isset($error))
                        <div class="alert alert-danger" role="alert">
                            {{ $error }}
                        </div>
                    @endif

                    <p>Welcome, {{ $user->name }}!</p>
                    
                    @if($isAdmin || $isAgent)
                        <!-- Stats Cards -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Total Tickets</h6>
                                        <p class="card-text h2">{{ $stats['total'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Open Tickets</h6>
                                        <p class="card-text h2">{{ $stats['open'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">Pending</h6>
                                        <p class="card-text h2">{{ $stats['pending'] }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-danger text-white">
                                    <div class="card-body">
                                        <h6 class="card-title">High Priority</h6>
                                        <p class="card-text h2">{{ $stats['high_priority'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($tickets->count() > 0)
                            <div class="card mt-4">
                                <div class="card-header">
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
                                                    <td>{{ $ticket->subject }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ strtolower($ticket->priority_name ?? 'secondary') }}">
                                                            {{ $ticket->priority_name ?? 'Unknown' }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge" style="background-color: {{ $ticket->status_color ?? '#6c757d' }}">
                                                            {{ $ticket->status_name ?? 'Unknown' }}
                                                        </span>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</td>
                                                    <td>
                                                        <a href="{{ route('staff.tickets.show', $ticket->id) }}" 
                                                           class="btn btn-sm btn-primary">
                                                            View
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info mt-4">
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

@push('styles')
<style>
.card-body .h2 {
    margin-bottom: 0;
}
.badge {
    padding: 0.4em 0.8em;
    font-size: 0.9em;
}
.table td {
    vertical-align: middle;
}
</style>
@endpush
@endsection