<!-- resources/views/dashboard/user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Welcome, {{ Auth::user()->name }}</h1>
        <p>User dashboard</p>
        
    </div>
</body>
</html>
