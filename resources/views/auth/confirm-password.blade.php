<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold text-ink sm:text-3xl">Konfirmasi Kata Sandi</h1>
        <p class="mt-1 text-sm text-ink-soft">Ini adalah area aman aplikasi. Harap konfirmasi kata sandi Anda sebelum melanjutkan.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="password" value="Kata Sandi" />
            <x-text-input
                id="password"
                class="mt-1.5 w-full"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">Konfirmasi</x-primary-button>
        </div>
    </form>
</x-guest-layout>
