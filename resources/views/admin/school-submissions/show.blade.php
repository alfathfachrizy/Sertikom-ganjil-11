@extends('layouts.admin')

@section('title', 'Tinjau Pengajuan')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <x-ui.page-header title="Detail Pengajuan" :subtitle="$submission->school_name" />
        <x-ui.status-badge :status="$submission->status" class="self-start sm:self-auto" />
    </div>
    <div class="mt-7 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-ui.card class="lg:col-span-2">
            <h2 class="font-display text-xl font-extrabold">Informasi Sekolah</h2>
            <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-primary-700">Nama sekolah</dt><dd class="mt-1 font-bold">{{ $submission->school_name }}</dd></div>
                <div><dt class="text-primary-700">Penanggung jawab</dt><dd class="mt-1 font-bold">{{ $submission->pic_name }}</dd></div>
                <div><dt class="text-primary-700">Nomor HP</dt><dd class="mt-1 font-bold">{{ $submission->pic_phone }}</dd></div>
                <div><dt class="text-primary-700">Jumlah peserta</dt><dd class="mt-1 font-bold">{{ number_format($submission->participant_count, 0, ',', '.') }} orang</dd></div>
                <div><dt class="text-primary-700">Tanggal kunjungan</dt><dd class="mt-1 font-bold">{{ $submission->order->visit_date->translatedFormat('d F Y') }}</dd></div>
                <div><dt class="text-primary-700">Pemesan</dt><dd class="mt-1 font-bold">{{ $submission->order->user->name }} · {{ $submission->order->user->email }}</dd></div>
            </dl>
            <div class="mt-6 border-t border-primary-100 pt-5">
                <h3 class="font-display text-lg font-extrabold">Rincian Pesanan {{ $submission->order->order_code }}</h3>
                @foreach ($submission->order->items as $item)
                    <div class="mt-3 flex flex-wrap justify-between gap-3 text-sm">
                        <span>{{ $item->schoolPackage?->name ?? 'Paket tidak tersedia' }} × {{ number_format($item->quantity, 0, ',', '.') }}</span>
                        <span class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <p class="mt-4 text-right font-display text-xl font-extrabold text-primary-700">Total Rp {{ number_format($submission->order->total_amount, 0, ',', '.') }}</p>
            </div>
        </x-ui.card>
        <x-ui.card>
            <h2 class="font-display text-xl font-extrabold">Tindakan Admin</h2>
            @if ($submission->status === 'pending')
                <p class="mt-2 text-sm text-primary-700">Periksa jadwal dan data rombongan sebelum memproses pengajuan.</p>
                <form method="POST" action="{{ route('admin.school-submissions.approve', $submission) }}" class="mt-5">
                    @csrf
                    <x-ui.button type="submit" class="w-full">✓ Setujui</x-ui.button>
                </form>
                <div x-data="{ rejectOpen: false }" class="mt-3">
                    <x-ui.button type="button" variant="danger" class="w-full" @click="rejectOpen = !rejectOpen">Tolak Pengajuan</x-ui.button>
                    <form x-show="rejectOpen" x-cloak method="POST" action="{{ route('admin.school-submissions.reject', $submission) }}" class="mt-4 space-y-3">
                        @csrf
                        <x-ui.field name="rejection_reason" label="Alasan Penolakan">
                            <textarea id="rejection_reason" name="rejection_reason" rows="4" required minlength="5" class="w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">{{ old('rejection_reason') }}</textarea>
                        </x-ui.field>
                        <x-ui.button type="submit" variant="danger" class="w-full">Konfirmasi Penolakan</x-ui.button>
                    </form>
                </div>
            @else
                <p class="mt-3 text-sm text-primary-800">Pengajuan telah diproses.</p>
                @if ($submission->rejection_reason)
                    <div class="mt-4 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        <p class="font-extrabold">Alasan penolakan</p>
                        <p class="mt-1">{{ $submission->rejection_reason }}</p>
                    </div>
                @endif
                <dl class="mt-4 space-y-2 text-sm">
                    <div><dt class="text-primary-700">Ditinjau oleh</dt><dd class="font-bold">{{ $submission->reviewer?->name ?? '—' }}</dd></div>
                    <div><dt class="text-primary-700">Waktu tinjau</dt><dd class="font-bold">{{ $submission->reviewed_at?->translatedFormat('d F Y, H:i') ?? '—' }}</dd></div>
                </dl>
            @endif
            <x-ui.button variant="ghost" :href="route('admin.school-submissions.index')" class="mt-5 w-full">Kembali ke Pengajuan</x-ui.button>
        </x-ui.card>
    </div>
@endsection
