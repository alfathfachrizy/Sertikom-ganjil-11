<x-guest-layout>
    <div class="mb-6 text-center">
        <p class="text-4xl">👋</p>
        <h1 class="mt-2 font-display text-3xl font-extrabold text-primary-900">Selamat Datang Kembali!</h1>
        <p class="mt-2 text-sm text-primary-800/75">Masuk dan lanjutkan keseruanmu di The Nice Park.</p>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" value="Kata Sandi" />
            <x-text-input id="password" class="mt-2 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <label for="remember_me" class="inline-flex min-h-11 items-center gap-2 text-sm font-semibold text-primary-800">
            <input id="remember_me" type="checkbox" class="rounded border-primary-300 text-primary-600 focus:ring-primary-300" name="remember">
            Ingat saya
        </label>
        <div class="flex flex-col-reverse items-center justify-between gap-3 sm:flex-row">
            @if (Route::has('password.request'))
                <a class="min-h-11 inline-flex items-center text-sm font-bold text-primary-700 hover:underline" href="{{ route('password.request') }}">Lupa kata sandi?</a>
            @endif
            <x-primary-button>Masuk</x-primary-button>
        </div>
    </form>
    <p class="mt-6 border-t border-primary-100 pt-5 text-center text-sm text-primary-800">Belum punya akun? <a class="font-extrabold text-primary-700 hover:underline" href="{{ route('register') }}">Daftar sekarang</a></p>
</x-guest-layout>
