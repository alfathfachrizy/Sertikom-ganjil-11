<form method="POST" action="{{ $package ? route('admin.school-packages.update', $package) : route('admin.school-packages.store') }}" class="space-y-5">
    @csrf
    @if ($package)
        @method('PUT')
    @endif

    <x-ui.field name="name" label="Nama Paket Sekolah">
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $package?->name) }}"
            required
            maxlength="255"
            placeholder="Contoh: Paket Edukasi Mini Zoo & Playground"
            class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
        >
    </x-ui.field>

    <x-ui.field name="description" label="Deskripsi Kegiatan & Fasilitas">
        <textarea
            id="description"
            name="description"
            rows="4"
            required
            placeholder="Rincian aktivitas edukasi dan fasilitas yang didapatkan peserta..."
            class="w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
        >{{ old('description', $package?->description) }}</textarea>
    </x-ui.field>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <x-ui.field name="price_per_participant" label="Harga per Peserta (Rp)">
            <input
                id="price_per_participant"
                name="price_per_participant"
                type="number"
                min="0"
                step="0.01"
                value="{{ old('price_per_participant', $package?->price_per_participant) }}"
                required
                placeholder="40000"
                class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
            >
        </x-ui.field>

        <x-ui.field name="min_participants" label="Syarat Minimal Peserta">
            <input
                id="min_participants"
                name="min_participants"
                type="number"
                min="1"
                value="{{ old('min_participants', $package?->min_participants ?? 20) }}"
                required
                placeholder="20"
                class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
            >
        </x-ui.field>
    </div>

    <div>
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex items-center gap-2.5 text-sm font-semibold text-ink cursor-pointer">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $package?->is_active ?? true))
                class="size-4 rounded border-line text-primary-600 focus:ring-primary-600/20"
            >
            <span>Aktifkan paket agar dapat diajukan oleh sekolah</span>
        </label>
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-line pt-5">
        <x-ui.button variant="ghost" :href="route('admin.school-packages.index')">Batal</x-ui.button>
        <x-ui.button type="submit">{{ $package ? 'Simpan Perubahan' : 'Tambah Paket' }}</x-ui.button>
    </div>
</form>
