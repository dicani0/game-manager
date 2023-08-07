<!DOCTYPE html>
<html>
<head>
    <title>Market Offer Expired</title>
</head>
<body>
<h2>Hello, {{ $offer->user->name }}</h2>
<p>
    Your market offer {{ $offer->getKey() }} has expired.
</p>
<p>
    You can check your offers history here: <a href="{{ url('market/history') }}">Your offers here</a>.
</p>
</body>
</html>
