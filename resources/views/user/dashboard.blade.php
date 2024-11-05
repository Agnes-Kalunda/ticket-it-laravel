@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Staff Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Welcome, {{ auth()->user()->name }}!</p>
                    
                    <div class="mt-4">
                        <h5>Ticket Management</h5>
                        <div class="list-group">
                            @if($isAgent || $isAdmin)
                                <a href="{{ route('staff.tickets.index', ['status' => 'open']) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Open Tickets</h6>
                                        <span class="badge badge-info badge-pill">
                                            {{ isset($tickets) ? $tickets->where('status_name', 'Open')->count() : '0' }}
                                        </span>
                                    </div>
                                </a>
                                <a href="{{ route('staff.tickets.index', ['status' => 'pending']) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Pending Response</h6>
                                        <span class="badge badge-warning badge-pill">
                                            {{ isset($tickets) ? $tickets->where('status_name', 'Pending')->count() : '0' }}
                                        </span>
                                    </div>
                                </a>
                            @endif
                        </div>

                        @if(isset($tickets) && $tickets->count() > 0)
                            <div class="mt-4">
                                <h5>Recent Tickets</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Subject</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tickets as $ticket)
                                            <tr>
                                                <td>{{ $ticket->id }}</td>
                                                <td>
                                                    <a href="{{ route('staff.tickets.show', $ticket->id) }}">
                                                        {{ $ticket->subject }}
                                                    </a>
                                                </td>
                                                <td>
                                                    <span class="badge" style="background-color: {{ $ticket->status_color ?? '#6c757d' }}">
                                                        {{ $ticket->status_name ?? 'Unknown' }}
                                                    </span>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="mt-4">
                                <p class="text-muted">No tickets found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.badge {
    color: white;
    padding: 0.35em 0.65em;
    font-size: 0.9em;
}
</style>
@endpush
@endsection