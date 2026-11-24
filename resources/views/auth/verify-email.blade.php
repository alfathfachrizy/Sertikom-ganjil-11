<x-guest-layout>
    <div class="mb-6 text-center">
        <h1 class="font-display text-2xl font-bold text-ink sm:text-3xl">Verifikasi Alamat Email</h1>
        <p class="mt-2 text-sm text-ink-soft leading-relaxed">
            Terima kasih telah mendaftar! Sebelum mulai, silakan verifikasi alamat email Anda melalui tautan yang baru saja kami kirimkan.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4">
            <x-ui.info-box variant="primary">
                Tautan verifikasi baru telah dikirimkan ke alamat email yang Anda daftarkan.
            </x-ui.info-box>
        </div>
    @endif

    <div class="mt-6 flex flex-col items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full">
            @csrf
            <x-primary-button class="w-full">
                Kirim Ulang Email Verifikasi
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-semibold text-ink-soft hover:text-red-600 transition">
                Keluar
            </button>
        </form>
    </div>
</x-guest-layout>
