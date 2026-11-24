<form method="POST" action="{{ $ticket ? route('admin.tickets.update', $ticket) : route('admin.tickets.store') }}" class="space-y-5">
    @csrf
    @if ($ticket)
        @method('PUT')
    @endif

    <x-ui.field name="name" label="Nama Tiket">
        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $ticket?->name) }}"
            required
            maxlength="255"
            placeholder="Contoh: Tiket Terusan Wahana"
            class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
        >
    </x-ui.field>

    <x-ui.field name="description" label="Deskripsi">
        <textarea
            id="description"
            name="description"
            rows="4"
            required
            placeholder="Tuliskan cakupan wahana dan fasilitas yang termasuk..."
            class="w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
        >{{ old('description', $ticket?->description) }}</textarea>
    </x-ui.field>

    <x-ui.field name="price" label="Harga Tiket (Rp)">
        <input
            id="price"
            name="price"
            type="number"
            min="0"
            step="0.01"
            value="{{ old('price', $ticket?->price) }}"
            required
            placeholder="35000"
            class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
        >
    </x-ui.field>

    <div>
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex items-center gap-2.5 text-sm font-semibold text-ink cursor-pointer">
            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old('is_active', $ticket?->is_active ?? true))
                class="size-4 rounded border-line text-primary-600 focus:ring-primary-600/20"
            >
            <span>Aktifkan tiket di katalog publik</span>
        </label>
    </div>

    <div class="flex items-center justify-end gap-3 border-t border-line pt-5">
        <x-ui.button variant="ghost" :href="route('admin.tickets.index')">Batal</x-ui.button>
        <x-ui.button type="submit">{{ $ticket ? 'Simpan Perubahan' : 'Tambah Tiket' }}</x-ui.button>
    </div>
</form>
