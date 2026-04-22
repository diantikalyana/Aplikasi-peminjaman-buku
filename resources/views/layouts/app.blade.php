<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>

    @vite('resources/css/app.css')

    {{-- ALPINE (cukup sekali) --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- MAIN --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        @include('components.header')

        {{-- CONTENT --}}
        <main class="px-0 py-6 w-full">
    @yield('content')
</main>
    </div>

</div>

{{-- SCRIPT STACK (WAJIB DI SINI) --}}
@stack('scripts')

</body>
</html>