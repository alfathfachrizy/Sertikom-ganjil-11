@extends('layouts.admin')

@section('title', 'Pengajuan Rombongan Sekolah')

@section('content')
    <x-ui.page-header
        title="Pengajuan Rombongan Sekolah"
        subtitle="Verifikasi permohonan kunjungan rombongan siswa sebelum pembayaran diterbitkan."
    />

    {{-- Filter Status (Segmented Control / Tab Sederhana) --}}
    <div class="mt-6 flex flex-wrap gap-2">
        @foreach ([
            ['value' => '', 'label' => 'Semua'],
            ['value' => 'pending', 'label' => 'Menunggu'],
            ['value' => 'approved', 'label' => 'Disetujui'],
            ['value' => 'rejected', 'label' => 'Ditolak'],
        ] as $filter)
            <a
                href="{{ route('admin.school-submissions.index', $filter['value'] !== '' ? ['status' => $filter['value']] : []) }}"
                @class([
                    'inline-flex min-h-[38px] items-center rounded-full px-4 text-xs font-bold transition duration-150',
                    'bg-primary-700 text-white shadow-xs' => request('status', '') === $filter['value'],
                    'bg-white text-ink border border-line hover:bg-primary-50' => request('status', '') !== $filter['value'],
                ])
            >
                {{ $filter['label'] }}
            </a>
        @endforeach
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-line bg-white shadow-sm">
        @if ($submissions->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full min-w-[950px] text-left text-sm">
                    <thead class="sticky top-0 bg-primary-50/60 text-xs font-bold uppercase tracking-wider text-ink-soft border-b border-line">
                        <tr>
                            <th scope="col" class="px-6 py-4">Nama Sekolah</th>
                            <th scope="col" class="px-6 py-4">Penanggung Jawab</th>
                            <th scope="col" class="px-6 py-4">Paket Pilihan</th>
                            <th scope="col" class="px-6 py-4 text-center">Peserta</th>
                            <th scope="col" class="px-6 py-4">Tanggal Kunjungan</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($submissions as $submission)
                            <tr class="transition hover:bg-cream/40">
                                <td class="px-6 py-4 font-bold text-ink">
                                    {{ $submission->school_name }}
                                </td>
                                <td class="px-6 py-4 text-ink">
                                    <p class="font-semibold">{{ $submission->pic_name }}</p>
                                    <p class="text-xs text-ink-soft">{{ $submission->pic_phone }}</p>
                                </td>
                                <td class="px-6 py-4 text-ink-soft">
                                    {{ $submission->order->items->first()?->schoolPackage?->name ?? 'Paket tidak tersedia' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center font-bold text-ink">
                                    {{ number_format($submission->participant_count, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-ink-soft">
                                    {{ $submission->order->visit_date->translatedFormat('d F Y') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <x-ui.status-badge :status="$submission->status" />
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <x-ui.button variant="ghost" size="sm" :href="route('admin.school-submissions.show', $submission)">
                                        <span>Tinjau</span>
                                        <x-ui.icon name="arrow-right" class="size-4" />
                                    </x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-line px-6 py-4">
                {{ $submissions->links() }}
            </div>
        @else
            <div class="p-8">
                <x-ui.empty-state
                    title="Tidak ada pengajuan sekolah"
                    message="Daftar pengajuan rombongan sekolah yang masuk akan ditampilkan pada tabel ini."
                    icon="school"
                />
            </div>
        @endif
    </div>
@endsection
