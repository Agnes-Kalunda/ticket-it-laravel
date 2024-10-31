
<form method="POST" action="{{ route('customer.login') }}">
    @csrf
    <div>
        <label for="username">Username</label>
        <input id="username" type="text" name="username" required>
    </div>

    <div>
        <label for="password">Password</label>
        <input id="password" type="password" name="password" required>
    </div>

    <button type="submit">Login as Customer</button>
</form>
