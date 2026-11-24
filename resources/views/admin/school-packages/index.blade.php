@extends('layouts.admin')

@section('title', 'Kelola Paket Sekolah')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <x-ui.page-header
            title="Kelola Paket Sekolah"
            subtitle="Atur program kegiatan kunjungan edukasi untuk rombongan sekolah."
        />
        <x-ui.button :href="route('admin.school-packages.create')">
            <x-ui.icon name="plus" class="size-4" />
            <span>Tambah Paket</span>
        </x-ui.button>
    </div>

    <div class="mt-8 overflow-hidden rounded-2xl border border-line bg-white shadow-sm">
        @if ($packages->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-left text-sm">
                    <thead class="sticky top-0 bg-primary-50/60 text-xs font-bold uppercase tracking-wider text-ink-soft border-b border-line">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama Paket & Deskripsi</th>
                            <th scope="col" class="px-6 py-4 text-right">Tarif / Peserta</th>
                            <th scope="col" class="px-6 py-4 text-center">Minimal Peserta</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($packages as $package)
                            <tr class="transition hover:bg-cream/40">
                                <td class="px-6 py-4">
                                    <p class="font-bold text-ink">{{ $package->name }}</p>
                                    <p class="mt-1 line-clamp-1 max-w-md text-xs text-ink-soft">{{ $package->description }}</p>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right font-bold text-ink">
                                    Rp {{ number_format($package->price_per_participant, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-ink-soft">
                                    {{ number_format($package->min_participants, 0, ',', '.') }} orang
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <span @class([
                                        'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border',
                                        'bg-primary-100 text-primary-900 border-primary-200' => $package->is_active,
                                        'bg-gray-100 text-gray-700 border-gray-200' => ! $package->is_active,
                                    ])>
                                        {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-2">
                                        <x-ui.button variant="ghost" size="sm" :href="route('admin.school-packages.edit', $package)" aria-label="Edit paket {{ $package->name }}">
                                            <x-ui.icon name="pencil" class="size-4" />
                                            <span class="sr-only sm:not-sr-only">Edit</span>
                                        </x-ui.button>
                                        <form method="POST" action="{{ route('admin.school-packages.destroy', $package) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="inline-flex size-9 items-center justify-center rounded-full text-red-600 transition hover:bg-red-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-600"
                                                aria-label="Hapus paket {{ $package->name }}"
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
                {{ $packages->links() }}
            </div>
        @else
            <div class="p-8">
                <x-ui.empty-state
                    title="Belum ada paket rombongan sekolah"
                    message="Tambahkan paket pertama untuk mulai menerima reservasi rombongan sekolah."
                    :href="route('admin.school-packages.create')"
                    button="Tambah Paket Sekarang"
                    icon="school"
                />
            </div>
        @endif
    </div>
@endsection
