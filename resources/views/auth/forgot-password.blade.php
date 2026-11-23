<x-guest-layout>
    <div class="mb-6 text-center">
        <p class="text-4xl">🔐</p>
        <h1 class="mt-2 font-display text-3xl font-extrabold text-primary-900">Lupa Kata Sandi?</h1>
        <p class="mt-2 text-sm leading-6 text-primary-800/75">Masukkan alamat email akun Anda. Kami akan mengirim tautan untuk membuat kata sandi baru.</p>
    </div>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="mt-2 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div class="flex flex-col-reverse items-center justify-between gap-3 sm:flex-row">
            <a class="min-h-11 inline-flex items-center text-sm font-bold text-primary-700 hover:underline" href="{{ route('login') }}">Kembali ke Masuk</a>
            <x-primary-button>Kirim Tautan Reset</x-primary-button>
        </div>
    </form>
    <p class="mt-5 text-center text-sm text-primary-800">Belum punya akun? <a class="font-bold text-primary-700 hover:underline" href="{{ route('register') }}">Daftar</a></p>
</x-guest-layout>
