<section class="max-w-xl">
    <header>
        <h2 class="font-display text-xl font-bold text-ink">Informasi Akun</h2>
        <p class="mt-1 text-sm text-ink-soft">Perbarui nama lengkap dan alamat email yang terdaftar.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nama Lengkap" />
            <x-text-input id="name" name="name" type="text" class="mt-1.5 w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="Alamat Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1.5 w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-1.5" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <x-ui.info-box variant="sunny">
                        <div>
                            <p>Alamat email Anda belum diverifikasi.</p>
                            <button form="send-verification" class="mt-1 text-xs font-bold text-primary-700 underline">
                                Kirim ulang email verifikasi
                            </button>
                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-1 text-xs font-semibold text-primary-700">Tautan verifikasi baru telah dikirim.</p>
                            @endif
                        </div>
                    </x-ui.info-box>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>Simpan Perubahan</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2500)"
                    class="text-sm font-semibold text-primary-700"
                >
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>
</section>
