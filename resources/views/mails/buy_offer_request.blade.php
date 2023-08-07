<!DOCTYPE html>
<html>
<head>
    <title>Trade Request Notification</title>
</head>
<body>
<h2>Hello, {{ $offer->user->name }}</h2>
<p>
    You have received a new trade request from {{ $offerRequest->creator->name }}.
</p>
<p>
    Please log in to your account to review this trade request <a href="{{ url('market/my') }}">Your offers here</a>. Remember to ensure the trade is fair and beneficial for both parties before accepting.
</p>
<p>
    Happy trading!
</p>
</body>
</html>
