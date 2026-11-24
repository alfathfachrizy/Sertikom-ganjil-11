<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold text-ink sm:text-3xl">Lupa Kata Sandi?</h1>
        <p class="mt-1 text-sm text-ink-soft">Masukkan email Anda, kami akan mengirimkan tautan untuk mengatur ulang kata sandi.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="mt-1.5 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">Kirim Tautan Reset</x-primary-button>
        </div>
    </form>

    <div class="mt-6 border-t border-line pt-4 text-center text-sm text-ink-soft">
        Kembali ke
        <a class="font-bold text-primary-700 hover:text-primary-800" href="{{ route('login') }}">Halaman Masuk</a>
    </div>
</x-guest-layout>
