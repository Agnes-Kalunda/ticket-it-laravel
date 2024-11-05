{{-- resources/views/customer/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Customer Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Welcome, {{ $customer->username }}!</p>
                   
                    <p>Email: {{ $customer->email }}</p>
                    
                    <div class="mt-4">
                        <h5>Support Tickets</h5>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('customer.tickets.create') }}" class="btn btn-primary mb-2">Submit New Ticket</a></li>

                        </ul>
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
                                            <a href="{{ route('customer.tickets.index') }}">
                                                {{ $ticket->subject }}
                                            </a>
                                        </td>
                                        <td>
                                            @if(isset($ticket->status))
                                                <span class="badge" style="background-color: {{ $ticket->status->color ?? '#6c757d' }}">
                                                    {{ $ticket->status->name ?? 'Unknown' }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>{{ $ticket->created_at ? $ticket->created_at->diffForHumans() : 'N/A' }}</td>
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