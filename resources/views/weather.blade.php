<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Data</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center bg-white shadow-md rounded p-8 max-w-md mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-700">Current Weather Data</h1>
        <div class="mb-4">
            <span class="text-lg font-medium text-gray-600">Temperature:</span>
            <span class="text-lg text-gray-800">{{ $t1hValue }} °C</span>
        </div>
        <div class="mb-4">
            <span class="text-lg font-medium text-gray-600">Humidity:</span>
            <span class="text-lg text-gray-800">{{ $rehValue }} %</span>
        </div>
        <div class="mb-4">
            <span class="text-lg font-medium text-gray-600">Date:</span>
            <span class="text-lg text-gray-800">{{ $baseDate }}</span>
        </div>
        <div class="mb-4">
            <span class="text-lg font-medium text-gray-600">Time:</span>
            <span class="text-lg text-gray-800">{{ $baseTime }}</span>
        </div>
    </div>
</body>
</html>
