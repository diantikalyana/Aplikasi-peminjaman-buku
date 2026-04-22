<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Perpustakaan SMK Ma'arif Walisongo Kajoran</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="relative bg-gradient-to-br from-blue-100 via-white to-blue-200 text-gray-800 overflow-x-hidden">

<!-- BACKGROUND ORNAMEN -->
<div class="absolute inset-0 -z-10 overflow-hidden">

    <!-- blur blobs -->
    <div class="absolute top-[-120px] left-[-120px] w-80 h-80 bg-blue-300 opacity-30 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute bottom-[-120px] right-[-120px] w-80 h-80 bg-indigo-400 opacity-30 rounded-full blur-3xl animate-pulse"></div>
    <div class="absolute top-1/2 left-1/2 w-[500px] h-[500px] bg-cyan-200 opacity-20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>

    <!-- grid texture -->
    <div class="absolute inset-0 opacity-10"
        style="background-image: radial-gradient(circle, #3b82f6 1px, transparent 1px); background-size: 30px 30px;">
    </div>

</div>


<!-- NAVBAR -->
<header class="flex justify-between items-center px-8 py-4 backdrop-blur-md bg-white/70 border-b border-white/30 sticky top-0 z-50">
    
    <h1 class="text-xl font-bold text-blue-600 tracking-wide">
        PERPUSTAKAAN SMKMW9
    </h1>

    <nav class="flex gap-4">
        @auth
            <a href="{{ url('/dashboard') }}" 
               class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow hover:scale-105 transition">
                Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" 
               class="px-4 py-2 border border-blue-200 rounded-lg hover:bg-blue-50 transition">
                Login
            </a>
            <a href="{{ route('register') }}" 
               class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg shadow hover:scale-105 transition">
                Register
            </a>
        @endauth
    </nav>

</header>


<!-- HERO -->
<section class="relative grid md:grid-cols-2 gap-10 items-center px-8 py-24">

    <!-- dekorasi -->
    <div class="absolute -top-10 right-20 w-40 h-40 bg-blue-200 opacity-40 rounded-full blur-2xl"></div>

    <div>
        <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
            Kelola & Pinjam Buku 
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-500 via-indigo-500 to-cyan-500">
                Lebih Mudah
            </span>
        </h2>

        <p class="mb-6 text-gray-600 text-lg">
            Aplikasi perpustakaan digital modern dengan sistem cepat, rapi, dan efisien.
        </p>

        <div class="flex gap-4">
            <a href="{{ route('register') }}" 
               class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-lg hover:scale-105 transition">
                Mulai →
            </a>

        </div>
    </div>

    <div class="relative">
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-400/30 to-cyan-100 blur-2xl rounded-3xl"></div>
        <img src="{{ asset('hero.png') }}" 
             class="relative rounded-3xl shadow-2xl w-full h-80 object-cover hover:scale-105 transition">
    </div>

</section>


<!-- FEATURES -->
<section class="px-8 py-20 text-center">

    <h3 class="text-3xl font-bold mb-12 text-blue-700">Fitur Utama</h3>

    <div class="grid md:grid-cols-3 gap-8">

        <div class="p-6 rounded-2xl bg-white/60 backdrop-blur-md shadow-xl hover:-translate-y-2 hover:shadow-2xl transition">
            <h4 class="font-bold text-lg mb-2 text-blue-600"> Cari Buku</h4>
            <p class="text-gray-600">Temukan buku dengan cepat dan akurat.</p>
        </div>

        <div class="p-6 rounded-2xl bg-white/60 backdrop-blur-md shadow-xl hover:-translate-y-2 hover:shadow-2xl transition">
            <h4 class="font-bold text-lg mb-2 text-indigo-600"> Peminjaman</h4>
            <p class="text-gray-600">Sistem peminjaman otomatis & efisien.</p>
        </div>

        <div class="p-6 rounded-2xl bg-white/60 backdrop-blur-md shadow-xl hover:-translate-y-2 hover:shadow-2xl transition">
            <h4 class="font-bold text-lg mb-2 text-cyan-600"> Wishlist</h4>
            <p class="text-gray-600">Simpan buku favoritmu dengan mudah.</p>
        </div>

    </div>

</section>


<!-- ABOUT -->
<section class="grid md:grid-cols-2 gap-10 items-center px-8 py-24">

    <div class="relative">
        <div class="absolute inset-0 bg-indigo-300/20 blur-2xl rounded-3xl"></div>
        <img src="{{ asset('about.png') }}" 
             class="relative rounded-3xl shadow-2xl w-full h-80 object-cover hover:scale-105 transition">
    </div>

    <div>
        <h3 class="text-3xl font-bold mb-4 text-indigo-700">Kenapa Pakai PerpusKu?</h3>

        <p class="text-gray-600 mb-4">
            Sistem modern yang bikin pengelolaan perpustakaan jadi lebih praktis dan profesional.
        </p>

        <ul class="text-gray-600 space-y-2">
            <li>✔ Tracking otomatis</li>
            <li>✔ Data aman</li>
            <li>✔ UI modern & cepat</li>
        </ul>
    </div>

</section>


<!-- CTA -->
<section class="text-center py-24 bg-gradient-to-r from-blue-500 via-indigo-600 to-cyan-500 text-white relative overflow-hidden">

    <!-- glow -->
    <div class="absolute inset-0 bg-white/10 backdrop-blur-sm"></div>

    <div class="relative z-10">
        <h3 class="text-3xl font-bold mb-4">Siap Mulai?</h3>
        <p class="mb-6 text-blue-100">Daftar sekarang dan mulai perjalanan digitalmu </p>

        <a href="{{ route('register') }}" 
           class="px-6 py-3 bg-white text-blue-600 rounded-xl shadow-lg hover:scale-105 transition">
            Daftar Sekarang
        </a>
    </div>

</section>


<!-- FOOTER -->
<footer class="text-center py-6 bg-white/70 backdrop-blur-md text-gray-500">
    © {{ date('Y') }} LB SMKMW9 - All rights reserved
</footer>

</body>
</html>