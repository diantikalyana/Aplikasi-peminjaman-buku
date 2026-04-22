<x-guest-layout>
>

        <div class="w-full max-w-md">

            <!-- HEADER -->
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-sky-700">Selamat Datang 👋</h1>
                <p class="text-sm text-sky-500 mt-1">
                    Masuk untuk melanjutkan ke sistem perpustakaan
                </p>
            </div>

            <!-- CARD -->
            <div class="bg-white/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-sky-100">

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- EMAIL -->
                    <div>
                        <x-input-label for="email" value="Email" />
                        <x-text-input id="email"
                            class="block mt-1 w-full rounded-lg border-gray-300 focus:border-sky-400 focus:ring focus:ring-sky-200 transition"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- PASSWORD -->
                    <div>
                        <x-input-label for="password" value="Password" />
                        <x-text-input id="password"
                            class="block mt-1 w-full rounded-lg border-gray-300 focus:border-sky-400 focus:ring focus:ring-sky-200 transition"
                            type="password"
                            name="password"
                            required />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- OPTIONS -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox"
                                class="rounded border-gray-300 text-sky-600 focus:ring-sky-400"
                                name="remember">
                            <span class="text-gray-600">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sky-600 hover:text-sky-700 hover:underline">
                               Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- BUTTON -->
                    <button
                        class="w-full bg-gradient-to-r from-sky-500 to-blue-500 text-white py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                        Log in
                    </button>

                    <!-- FOOTER -->
                    <div class="text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                           class="text-sky-600 font-medium hover:underline">
                           Registrasi
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-guest-layout>