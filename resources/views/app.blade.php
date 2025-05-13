<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/images/computer_icon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/images/computer_icon.ico">
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
