<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold text-ink sm:text-3xl">Atur Ulang Kata Sandi</h1>
        <p class="mt-1 text-sm text-ink-soft">Silakan buat kata sandi baru untuk mengamankan akun Anda.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="mt-1.5 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password" value="Kata Sandi Baru" />
            <x-text-input id="password" class="mt-1.5 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi Baru" />
            <x-text-input id="password_confirmation" class="mt-1.5 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">Simpan Kata Sandi Baru</x-primary-button>
        </div>
    </form>

    <div class="mt-6 border-t border-line pt-4 text-center text-sm text-ink-soft">
        Ingat kata sandi?
        <a class="font-bold text-primary-700 hover:text-primary-800" href="{{ route('login') }}">Masuk di sini</a>
    </div>
</x-guest-layout>
