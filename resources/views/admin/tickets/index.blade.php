@extends('layouts.admin')

@section('title', 'Kelola Tiket')

@section('content')
    <x-ui.page-header title="Kelola Tiket" subtitle="Atur harga, deskripsi, dan ketersediaan tiket.">
        <x-slot name="actions"><x-ui.button :href="route('admin.tickets.create')">＋ Tambah Tiket</x-ui.button></x-slot>
    </x-ui.page-header>
    <x-ui.card class="mt-8 p-0">
        @if ($tickets->isNotEmpty())
            <div class="overflow-x-auto rounded-3xl">
                <table class="w-full min-w-[700px] text-left text-sm">
                    <thead class="bg-primary-50 text-primary-800"><tr><th class="px-5 py-4">Nama</th><th class="px-5 py-4">Harga</th><th class="px-5 py-4">Status</th><th class="px-5 py-4 text-right">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-primary-50">
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-cream">
                                <td class="px-5 py-4"><p class="font-bold">{{ $ticket->name }}</p><p class="mt-1 max-w-md text-xs text-primary-700">{{ \Illuminate\Support\Str::limit($ticket->description, 90) }}</p></td>
                                <td class="whitespace-nowrap px-5 py-4 font-bold">Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                                <td class="px-5 py-4"><span @class(['rounded-full px-3 py-1 text-xs font-extrabold', 'bg-primary-100 text-primary-800' => $ticket->is_active, 'bg-gray-100 text-gray-700' => ! $ticket->is_active])>{{ $ticket->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                                <td class="px-5 py-4"><div class="flex justify-end gap-2">
                                    <x-ui.button variant="secondary" :href="route('admin.tickets.edit', $ticket)">Edit</x-ui.button>
                                    <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <x-ui.button type="submit" variant="danger">Hapus</x-ui.button>
                                    </form>
                                </div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4">{{ $tickets->links() }}</div>
        @else
            <div class="p-5"><x-ui.empty-state title="Belum ada tiket" message="Tambahkan tiket agar pengunjung dapat mulai memesan." href="{{ route('admin.tickets.create') }}" button="Tambah Tiket" emoji="🎟️" /></div>
        @endif
    </x-ui.card>
@endsection
