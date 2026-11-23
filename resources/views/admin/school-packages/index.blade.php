@extends('layouts.admin')

@section('title', 'Kelola Paket Sekolah')

@section('content')
    <x-ui.page-header title="Paket Sekolah" subtitle="Atur pilihan kunjungan edukatif untuk rombongan.">
        <x-slot name="actions"><x-ui.button :href="route('admin.school-packages.create')">＋ Tambah Paket</x-ui.button></x-slot>
    </x-ui.page-header>
    <x-ui.card class="mt-8 p-0">
        @if ($packages->isNotEmpty())
            <div class="overflow-x-auto rounded-3xl">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="bg-primary-50 text-primary-800"><tr><th class="px-5 py-4">Nama</th><th class="px-5 py-4">Harga / Peserta</th><th class="px-5 py-4">Minimum</th><th class="px-5 py-4">Status</th><th class="px-5 py-4 text-right">Aksi</th></tr></thead>
                    <tbody class="divide-y divide-primary-50">
                        @foreach ($packages as $package)
                            <tr class="hover:bg-cream">
                                <td class="px-5 py-4"><p class="font-bold">{{ $package->name }}</p><p class="mt-1 max-w-md text-xs text-primary-700">{{ \Illuminate\Support\Str::limit($package->description, 90) }}</p></td>
                                <td class="whitespace-nowrap px-5 py-4 font-bold">Rp {{ number_format($package->price_per_participant, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-5 py-4">{{ number_format($package->min_participants, 0, ',', '.') }} peserta</td>
                                <td class="px-5 py-4"><span @class(['rounded-full px-3 py-1 text-xs font-extrabold', 'bg-primary-100 text-primary-800' => $package->is_active, 'bg-gray-100 text-gray-700' => ! $package->is_active])>{{ $package->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                                <td class="px-5 py-4"><div class="flex justify-end gap-2">
                                    <x-ui.button variant="secondary" :href="route('admin.school-packages.edit', $package)">Edit</x-ui.button>
                                    <form method="POST" action="{{ route('admin.school-packages.destroy', $package) }}" onsubmit="return confirm('Hapus data ini?')">
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
            <div class="px-5 py-4">{{ $packages->links() }}</div>
        @else
            <div class="p-5"><x-ui.empty-state title="Belum ada paket sekolah" message="Tambahkan paket untuk menerima pengajuan rombongan." href="{{ route('admin.school-packages.create') }}" button="Tambah Paket" emoji="🎒" /></div>
        @endif
    </x-ui.card>
@endsection
