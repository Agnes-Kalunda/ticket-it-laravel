
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Welcome, {{ $user->name }}!</p>
                    <p>Email: {{ $user->email }}</p>
                    
                    <div class="mt-4">
                        <h5>Quick Actions</h5>
                        <ul class="list-unstyled">
                            <li><a href="#" class="btn btn-primary mb-2">View Tickets</a></li>
                            <li><a href="#" class="btn btn-secondary">Manage Profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection