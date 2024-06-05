<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<h1>Register</h1>
<form method="post" action="{{ route('register.submit') }}" enctype="multipart/form-data">
    @csrf
    <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="userIcon">Icon:</label>
        <input type="file" id="userIcon" name="userIcon" accept=".jpg, .jpeg, .png">
    </div>
    <input type="submit" value="Register">
</form>
<a href="{{ route('login') }}">Back</a>
</body>
</html>
