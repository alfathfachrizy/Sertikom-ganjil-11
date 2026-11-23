@extends('layouts.admin')

@section('title', 'Pengajuan Sekolah')

@section('content')
    <x-ui.page-header title="Pengajuan Sekolah" subtitle="Tinjau dan kelola permohonan kunjungan rombongan." />
    <div class="mt-6 flex flex-wrap gap-2">
        @foreach ([['value' => '', 'label' => 'Semua'], ['value' => 'pending', 'label' => 'Menunggu'], ['value' => 'approved', 'label' => 'Disetujui'], ['value' => 'rejected', 'label' => 'Ditolak']] as $filter)
            <a href="{{ route('admin.school-submissions.index', $filter['value'] !== '' ? ['status' => $filter['value']] : []) }}" @class(['inline-flex min-h-11 items-center rounded-full px-5 py-2 font-bold', 'bg-primary-600 text-white' => request('status', '') === $filter['value'], 'bg-white text-primary-800 ring-1 ring-primary-100 hover:bg-primary-50' => request('status', '') !== $filter['value']])>{{ $filter['label'] }}</a>
        @endforeach
    </div>
    <x-ui.card class="mt-5 p-0">
        @if ($submissions->isNotEmpty())
            <div class="overflow-x-auto rounded-3xl">
                <table class="w-full min-w-[980px] text-left text-sm">
                    <thead class="bg-primary-50 text-primary-800"><tr><th class="px-5 py-4">Sekolah</th><th class="px-5 py-4">Penanggung Jawab</th><th class="px-5 py-4">Paket</th><th class="px-5 py-4">Peserta</th><th class="px-5 py-4">Tanggal Kunjungan</th><th class="px-5 py-4">Status</th><th class="px-5 py-4"></th></tr></thead>
                    <tbody class="divide-y divide-primary-50">
                        @foreach ($submissions as $submission)
                            <tr class="hover:bg-cream">
                                <td class="px-5 py-4 font-bold">{{ $submission->school_name }}</td>
                                <td class="px-5 py-4">{{ $submission->pic_name }}<p class="text-xs text-primary-700">{{ $submission->pic_phone }}</p></td>
                                <td class="px-5 py-4">{{ $submission->order->items->first()?->schoolPackage?->name ?? 'Paket tidak tersedia' }}</td>
                                <td class="px-5 py-4">{{ number_format($submission->participant_count, 0, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-5 py-4">{{ $submission->order->visit_date->translatedFormat('d F Y') }}</td>
                                <td class="px-5 py-4"><x-ui.status-badge :status="$submission->status" /></td>
                                <td class="px-5 py-4 text-right"><x-ui.button :href="route('admin.school-submissions.show', $submission)">Tinjau</x-ui.button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4">{{ $submissions->links() }}</div>
        @else
            <div class="p-5"><x-ui.empty-state title="Belum ada pengajuan" message="Pengajuan sekolah akan muncul di halaman ini." emoji="🏫" /></div>
        @endif
    </x-ui.card>
@endsection
