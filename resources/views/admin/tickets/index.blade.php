@extends('layouts.admin')

@section('title', 'Kelola Tiket')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <x-ui.page-header
            title="Kelola Tiket Masuk"
            subtitle="Atur daftar tiket reguler, harga satuan, dan status ketersediaan tiket."
        />
        <x-ui.button :href="route('admin.tickets.create')">
            <x-ui.icon name="plus" class="size-4" />
            <span>Tambah Tiket</span>
        </x-ui.button>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-line bg-white shadow-sm">
        @if ($tickets->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full min-w-[700px] text-left text-sm">
                    <thead class="sticky top-0 bg-primary-50/60 text-xs font-bold uppercase tracking-wider text-ink-soft border-b border-line">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama Tiket & Deskripsi</th>
                            <th scope="col" class="px-6 py-4 text-right">Harga</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($tickets as $ticket)
                            <tr class="transition hover:bg-cream/40">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-ink">{{ $ticket->name }}</p>
                                    <p class="mt-1 line-clamp-1 max-w-md text-xs text-ink-soft">{{ $ticket->description }}</p>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right font-bold text-ink">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span @class([
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border',
                                        'bg-primary-100 text-primary-900 border-primary-200' => $ticket->is_active,
                                        'bg-gray-100 text-gray-700 border-gray-200' => ! $ticket->is_active,
                                    ])>
                                        {{ $ticket->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <x-ui.button variant="ghost" size="sm" :href="route('admin.tickets.edit', $ticket)" aria-label="Edit tiket {{ $ticket->name }}">
                                            <x-ui.icon name="pencil" class="size-4" />
                                            <span class="sr-only sm:not-sr-only">Edit</span>
                                        </x-ui.button>
                                        <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tiket ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="inline-flex size-9 items-center justify-center rounded-full text-red-600 transition hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-600"
                                                aria-label="Hapus tiket {{ $ticket->name }}"
                                            >
                                                <x-ui.icon name="trash" class="size-4" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-line px-6 py-4">
                {{ $tickets->links() }}
            </div>
        @else
            <div class="p-8">
                <x-ui.empty-state
                    title="Belum ada tiket terdaftar"
                    message="Tambahkan tiket reguler pertama untuk ditampilkan di katalog tiket publik."
                    :href="route('admin.tickets.create')"
                    button="Tambah Tiket Sekarang"
                    icon="ticket"
                />
            </div>
        @endif
    </div>
@endsection
