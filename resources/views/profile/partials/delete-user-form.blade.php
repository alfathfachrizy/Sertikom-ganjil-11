<section class="space-y-5">
    <header>
        <h2 class="font-display text-xl font-extrabold text-red-800">Hapus Akun</h2>
        <p class="mt-1 text-sm leading-6 text-primary-800/75">Setelah akun dihapus, seluruh data akun akan dihapus secara permanen. Pastikan Anda sudah menyimpan informasi yang diperlukan.</p>
    </header>
    <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Hapus Akun</x-danger-button>
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-5 p-6">
            @csrf
            @method('delete')
            <h2 class="font-display text-xl font-extrabold text-primary-900">Yakin ingin menghapus akun?</h2>
            <p class="text-sm leading-6 text-primary-800/75">Tindakan ini tidak dapat dibatalkan. Masukkan kata sandi untuk mengonfirmasi penghapusan akun.</p>
            <div>
                <x-input-label for="password" value="Kata Sandi" class="sr-only" />
                <x-text-input id="password" name="password" type="password" class="mt-1 w-full" placeholder="Kata Sandi" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>
            <div class="flex flex-wrap justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-danger-button>Ya, Hapus Akun</x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
