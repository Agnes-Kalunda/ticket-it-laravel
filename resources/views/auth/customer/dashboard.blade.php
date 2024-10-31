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

                    <p>Welcome, {{ auth('customer')->user()->name }}!</p>
                    
                    <div class="mt-4">
                        <h5>Support Tickets</h5>
                        <div class="mb-3">
                            <a href="#" class="btn btn-primary">Submit New Ticket</a>
                        </div>
                        
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">My Active Tickets</h6>
                                    <span class="badge badge-info badge-pill">0</span>
                                </div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Resolved Tickets</h6>
                                    <span class="badge badge-success badge-pill">0</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection