<form method="POST" action="{{ $ticket ? route('admin.tickets.update', $ticket) : route('admin.tickets.store') }}" class="space-y-5">
    @csrf
    @if ($ticket)
        @method('PUT')
    @endif
    <x-ui.field name="name" label="Nama Tiket">
        <input id="name" name="name" type="text" value="{{ old('name', $ticket?->name) }}" required maxlength="255" class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
    </x-ui.field>
    <x-ui.field name="description" label="Deskripsi">
        <textarea id="description" name="description" rows="4" required class="w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">{{ old('description', $ticket?->description) }}</textarea>
    </x-ui.field>
    <x-ui.field name="price" label="Harga (Rp)">
        <input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $ticket?->price) }}" required class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
    </x-ui.field>
    <div>
        <input type="hidden" name="is_active" value="0">
        <label class="inline-flex min-h-11 items-center gap-3 font-bold text-primary-900">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $ticket?->is_active ?? true)) class="h-5 w-5 rounded border-primary-300 text-primary-600 focus:ring-primary-300">
            Tiket aktif dan dapat dipesan
        </label>
    </div>
    <div class="flex flex-wrap gap-3">
        <x-ui.button type="submit">{{ $ticket ? 'Simpan Perubahan' : 'Tambah Tiket' }}</x-ui.button>
        <x-ui.button variant="ghost" :href="route('admin.tickets.index')">Batal</x-ui.button>
    </div>
</form>
