<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Support Ticket System') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row min-vh-100 align-items-center">
            <div class="col-12 text-center">
                <h1 class="display-4 mb-5">Support Ticket System</h1>
                
                <div class="row justify-content-center">
                    <!-- staff Section -->
                    <div class="col-md-5 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center p-5">
                                <h3 class="mb-4">Staff Access</h3>
                                <p class="text-muted mb-4">Manage support tickets</p>
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-5">Staff Login</a>
                            </div>
                        </div>
                    </div>

                    <!-- customer Section -->
                    <div class="col-md-5 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center p-5">
                                <h3 class="mb-4">Customer Access</h3>
                                <p class="text-muted mb-4">Submit and track tickets</p>
                                <a href="{{ route('customer.login') }}" class="btn btn-success btn-lg px-5 mb-3">Customer Login</a>
                                <div>
                                    <a href="{{ route('customer.register') }}" class="text-decoration-none">New customer? Register here</a>
                                </div>
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