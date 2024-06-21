<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Data</title>
    <link rel="stylesheet" href="{{ asset('css/app.8272c664.css') }}">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div id="app">
        <div class="text-center">
            <h1 class="text-3xl font-bold mb-4">Current Weather Data</h1>
            <p class="text-lg">Temperature: {{ $t1hValue }} °C</p>
            <p class="text-lg">Humidity: {{ $rehValue }} %</p>
            <p class="text-lg">Date: {{ $baseDate }}</p>
            <p class="text-lg">Time: {{ $baseTime }}</p>
        </div>
    </div>
    <script src="{{ asset('js/chunk-vendors.c57e0a83.js') }}"></script>
    <script src="{{ asset('js/app.07c3676d.js') }}"></script>
</body>
</html>
