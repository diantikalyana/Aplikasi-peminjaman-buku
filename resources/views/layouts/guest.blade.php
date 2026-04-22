<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>@yield('title', 'Perpustakaan')</title>

    <!-- FAVICON FIX TOTAL -->
<link rel="icon" href="/favicon.ico?v={{ time() }}">
<link rel="shortcut icon" href="/favicon.ico?v={{ time() }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="font-sans text-gray-900 antialiased">

    <div class="min-h-screen w-full flex items-center justify-center 
        bg-gradient-to-br from-sky-100 via-blue-50 to-white">

        <div class="w-full max-w-md px-4">
            {{ $slot }}
        </div>

    </div>

</body>
</html>
