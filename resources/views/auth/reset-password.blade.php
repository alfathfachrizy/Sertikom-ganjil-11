<x-guest-layout>
    <div class="mb-6 text-center">
        <p class="text-4xl">✨</p>
        <h1 class="mt-2 font-display text-3xl font-extrabold text-primary-900">Buat Kata Sandi Baru</h1>
        <p class="mt-2 text-sm text-primary-800/75">Gunakan kata sandi yang kuat agar akun tetap aman.</p>
    </div>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="mt-2 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" value="Kata Sandi Baru" />
            <x-text-input id="password" class="mt-2 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password_confirmation" value="Ulangi Kata Sandi Baru" />
            <x-text-input id="password_confirmation" class="mt-2 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex flex-col-reverse items-center justify-between gap-3 sm:flex-row">
            <a class="min-h-11 inline-flex items-center text-sm font-bold text-primary-700 hover:underline" href="{{ route('login') }}">Kembali ke Masuk</a>
            <x-primary-button>Simpan Kata Sandi Baru</x-primary-button>
        </div>
    </form>
    <p class="mt-5 text-center text-sm text-primary-800">Belum punya akun? <a class="font-bold text-primary-700 hover:underline" href="{{ route('register') }}">Daftar</a></p>
</x-guest-layout>
