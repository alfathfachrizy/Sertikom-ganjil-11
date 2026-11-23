<form method="POST" action="{{ $package ? route('admin.school-packages.update', $package) : route('admin.school-packages.store') }}" class="space-y-5">
    @csrf
    @if ($package)
        @method('PUT')
    @endif
    <x-ui.field name="name" label="Nama Paket">
        <input id="name" name="name" type="text" value="{{ old('name', $package?->name) }}" required maxlength="255" class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
    </x-ui.field>
    <x-ui.field name="description" label="Deskripsi">
        <textarea id="description" name="description" rows="4" required class="w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">{{ old('description', $package?->description) }}</textarea>
    </x-ui.field>
    <x-ui.field name="price_per_participant" label="Harga per Peserta (Rp)">
        <input id="price_per_participant" name="price_per_participant" type="number" min="0" step="0.01" value="{{ old('price_per_participant', $package?->price_per_participant) }}" required class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
    </x-ui.field>
    <x-ui.field name="min_participants" label="Jumlah Peserta Minimum">
        <input id="min_participants" name="min_participants" type="number" min="1" value="{{ old('min_participants', $package?->min_participants) }}" required class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
    </x-ui.field>
    <div>
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex min-h-11 items-center gap-3 font-bold text-primary-900">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $package?->is_active ?? true)) class="h-5 w-5 rounded border-primary-300 text-primary-600 focus:ring-primary-300">
            Paket aktif dan dapat diajukan
        </label>
    </div>
    <div class="flex flex-wrap gap-3">
        <x-ui.button type="submit">{{ $package ? 'Simpan Perubahan' : 'Tambah Paket' }}</x-ui.button>
        <x-ui.button variant="ghost" :href="route('admin.school-packages.index')">Batal</x-ui.button>
    </div>
</form>
