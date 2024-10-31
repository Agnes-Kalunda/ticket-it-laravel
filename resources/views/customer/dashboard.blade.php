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
                        <h5>Quick Actions</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="btn btn-primary mb-2">Submit New Ticket</a></li>
                            <li><a href="#" class="btn btn-info mb-2">View My Tickets</a></li>
                            <!-- <li><a href="#" class="btn btn-secondary">Manage Profile</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection