<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
</head>
<body>
<h2>Вашата резервация е потвърдена!</h2>
<p>Здравейте, {{ $booking->client_name }}!</p>
<p>Вашият час е запазен за: <strong>{{ $booking->date_time }}</strong></p>
<p>Доктор: <strong>{{ $booking->doctor->name }}</strong></p>
<p>Благодарим Ви!</p>
</body>
</html>
