<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Member</title>
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-sky-50">
        @include('partials.user_sidebar')
        @include('partials.user_header')

        <main class="pl-72 pr-6 py-6">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>

        @stack('scripts')
    </body>
</html>
