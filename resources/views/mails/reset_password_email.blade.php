<!DOCTYPE html>
<html>
<head>
    <title>Password Reset Request</title>
</head>
<body>
<h2>Hello, {{ $user->name }}</h2>
<p>
    You have requested to reset your password. Please click on the link below to reset your password. If you did not request a password reset, please ignore this email.
</p>
<p>
    <a href="{{ $url }}">Reset Password</a>
</p>
</body>
</html>
