<x-guest-layout>
    <div class="mb-6 text-center">
        <p class="text-4xl">🎉</p>
        <h1 class="mt-2 font-display text-3xl font-extrabold text-primary-900">Yuk, Gabung Keseruan!</h1>
        <p class="mt-2 text-sm text-primary-800/75">Buat akun untuk memesan tiket dan paket sekolah.</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" class="mt-2 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" class="mt-2 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="phone" value="Nomor Telepon (opsional)" />
            <x-text-input id="phone" class="mt-2 w-full" type="text" name="phone" :value="old('phone')" maxlength="20" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" value="Kata Sandi" />
            <x-text-input id="password" class="mt-2 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password_confirmation" value="Ulangi Kata Sandi" />
            <x-text-input id="password_confirmation" class="mt-2 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="flex flex-col-reverse items-center justify-between gap-3 pt-2 sm:flex-row">
            <a class="min-h-11 inline-flex items-center text-sm font-bold text-primary-700 hover:underline" href="{{ route('login') }}">Sudah punya akun? Masuk</a>
            <x-primary-button>Daftar</x-primary-button>
        </div>
    </form>
</x-guest-layout>
