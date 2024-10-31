<!-- resources/views/dashboard/customer.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Welcome, {{ Auth::guard('customer')->user()->name }}</h1>
        <p>Customer dashboard.</p>
        
    </div>
</body>
</html>
