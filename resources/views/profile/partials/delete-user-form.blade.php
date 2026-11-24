<section class="max-w-xl space-y-4">
    <header>
        <h2 class="font-display text-xl font-bold text-red-700">Hapus Akun</h2>
        <p class="mt-1 text-sm text-ink-soft leading-relaxed">
            Setelah akun Anda dihapus, semua riwayat data pemesanan dan akun akan dihapus permanen. Tindakan ini tidak dapat dibatalkan.
        </p>
    </header>

    <div>
        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            Hapus Akun Saya
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8 space-y-4">
            @csrf
            @method('delete')

            <h2 class="font-display text-xl font-bold text-ink">
                Konfirmasi Penghapusan Akun
            </h2>

            <p class="text-sm text-ink-soft leading-relaxed">
                Apakah Anda yakin ingin menghapus akun? Masukkan kata sandi Anda untuk mengonfirmasi penghapusan secara permanen.
            </p>

            <div>
                <x-input-label for="password" value="Kata Sandi" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 w-full"
                    placeholder="Masukkan kata sandi akun"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1.5" />
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Batal
                </x-secondary-button>

                <x-danger-button>
                    Ya, Hapus Akun
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
