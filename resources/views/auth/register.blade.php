<x-guest-layout>

    <div class="w-full max-w-md mx-auto">

        <!-- HEADER -->
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-sky-700">Buat Akun ✨</h1>
            <p class="text-sm text-sky-500 mt-1">
                Daftar untuk mulai meminjam buku
            </p>
        </div>

        <!-- CARD -->
        <div class="bg-white/80 backdrop-blur-md p-6 rounded-2xl shadow-xl border border-sky-100">

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- USERNAME -->
                <div>
                    <x-input-label for="name" value="Username" />
                    <x-text-input id="name" name="name"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-sky-400 focus:ring focus:ring-sky-200 transition"
                        placeholder="Masukkan username"
                        required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- EMAIL -->
                <div>
                    <x-input-label for="email" value="Email" />
                    <x-text-input id="email" name="email" type="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-sky-400 focus:ring focus:ring-sky-200 transition"
                        placeholder="Masukkan email"
                        required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- PASSWORD -->
                <div>
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" name="password" type="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-sky-400 focus:ring focus:ring-sky-200 transition"
                        placeholder="Masukkan password"
                        required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- CONFIRM PASSWORD -->
                <div>
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 focus:border-sky-400 focus:ring focus:ring-sky-200 transition"
                        placeholder="Ulangi password"
                        required />
                </div>

                <!-- BUTTON -->
                <button
                    class="w-full bg-gradient-to-r from-sky-500 to-blue-500 text-white py-2.5 rounded-lg font-medium shadow-md hover:shadow-lg hover:scale-[1.02] transition">
                    Register
                </button>

                <!-- FOOTER -->
                <div class="text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                       class="text-sky-600 font-medium hover:underline">
                       Masuk
                    </a>
                </div>

            </form>

        </div>

    </div>

</x-guest-layout>