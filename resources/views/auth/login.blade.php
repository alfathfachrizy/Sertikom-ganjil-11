<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold text-ink sm:text-3xl">Selamat Datang Kembali</h1>
        <p class="mt-1 text-sm text-ink-soft">Masuk ke akun Anda untuk melihat atau memesan tiket.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" value="Kata Sandi" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-primary-700 hover:text-primary-800" href="{{ route('password.request') }}">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="mt-1.5 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-ink-soft cursor-pointer">
                <input id="remember_me" type="checkbox" class="size-4 rounded border-line text-primary-600 focus:ring-primary-600/20" name="remember">
                <span>Ingat saya</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">Masuk ke Akun</x-primary-button>
        </div>
    </form>

    <div class="mt-6 border-t border-line pt-4 text-center text-sm text-ink-soft">
        Belum memiliki akun?
        <a class="font-bold text-primary-700 hover:text-primary-800" href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</x-guest-layout>
