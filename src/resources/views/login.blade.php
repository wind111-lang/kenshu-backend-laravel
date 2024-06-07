<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h1>Login</h1>
@if( session('loginError') )
    <p>{{ session('loginError') }}</p>
@endif
<form method="POST" action="{{ route('login.submit') }}">
    @csrf
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <input type="submit" value="Login">
</form>
<a href="{{ route('register') }}">Register</a>
<a href="{{ route('index') }}">Back</a>
</body>
</html>
