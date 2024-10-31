<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .btn-xl {
            padding: 1rem 2rem;
            font-size: 1.25rem;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row min-vh-100 align-items-center">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-5">Welcome to Support Ticket System</h1>
                
                <div class="row justify-content-center">
                    <!-- Staff Section -->
                    <div class="col-md-5 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h3 class="card-title mb-4">Staff Access</h3>
                                <p class="card-text mb-4">Login to manage customer support tickets</p>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-xl">Staff Login</a>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Section -->
                    <div class="col-md-5 mb-4">
                        <div class="card h-100">
                            <div class="card-body text-center">
                                <h3 class="card-title mb-4">Customer Access</h3>
                                <p class="card-text mb-4">Submit and track your support tickets</p>
                                @if(Route::has('customer.login'))
                                    <a href="{{ route('customer.login') }}" class="btn btn-success btn-xl mb-3">Customer Login</a>
                                    <div>
                                        <a href="{{ route('customer.register') }}" class="btn btn-link">New Customer? Register here</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>