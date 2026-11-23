@extends('layouts.public')

@section('title', 'Status Pengajuan')

@section('content')
    @php
        $status = $submission->order->status;
        $currentStep = match ($status) {
            'paid' => 3,
            'awaiting_payment', 'cancelled', 'expired' => 2,
            default => 1,
        };
        $steps = ['Diajukan', 'Ditinjau Admin', 'Pembayaran', 'E-ticket'];
    @endphp
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <x-ui.page-header title="Status Pengajuan Sekolah" subtitle="Pantau proses pengajuan kunjungan rombongan Anda." />
        <x-ui.card class="mt-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm font-bold text-primary-600">Pengajuan #{{ $submission->id }}</p>
                    <h2 class="mt-1 font-display text-2xl font-extrabold">{{ $submission->school_name }}</h2>
                </div>
                <x-ui.status-badge :status="$submission->status" />
            </div>
            <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ($steps as $index => $step)
                    <div class="text-center">
                        <span @class(['mx-auto flex h-10 w-10 items-center justify-center rounded-full font-extrabold', 'bg-primary-600 text-white' => $index <= $currentStep, 'bg-primary-100 text-primary-700' => $index > $currentStep])>
                            @if ($index < $currentStep) ✓ @else {{ $index + 1 }} @endif
                        </span>
                        <p class="mt-2 text-xs font-bold sm:text-sm">{{ $step }}</p>
                    </div>
                @endforeach
            </div>
        </x-ui.card>

        <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
            <x-ui.card>
                <h2 class="font-display text-xl font-extrabold">Data Rombongan</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between gap-3"><dt class="text-primary-700">Sekolah</dt><dd class="text-right font-bold">{{ $submission->school_name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-primary-700">Penanggung jawab</dt><dd class="text-right font-bold">{{ $submission->pic_name }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-primary-700">Nomor HP</dt><dd class="text-right font-bold">{{ $submission->pic_phone }}</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-primary-700">Peserta</dt><dd class="text-right font-bold">{{ number_format($submission->participant_count, 0, ',', '.') }} orang</dd></div>
                    <div class="flex justify-between gap-3"><dt class="text-primary-700">Tanggal kunjungan</dt><dd class="text-right font-bold">{{ $submission->order->visit_date->translatedFormat('d F Y') }}</dd></div>
                </dl>
            </x-ui.card>
            <x-ui.card class="flex flex-col">
                <h2 class="font-display text-xl font-extrabold">Ringkasan Pesanan</h2>
                <p class="mt-2 text-sm text-primary-700">{{ $submission->order->order_code }}</p>
                @foreach ($submission->order->items as $item)
                    <div class="mt-4 flex justify-between gap-3 text-sm">
                        <span>{{ $item->schoolPackage?->name }} × {{ $item->quantity }}</span>
                        <span class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <div class="mt-5 flex justify-between border-t border-primary-100 pt-4 font-extrabold">
                    <span>Total</span><span class="text-primary-700">Rp {{ number_format($submission->order->total_amount, 0, ',', '.') }}</span>
                </div>
                @if ($submission->status === 'rejected' && $submission->rejection_reason)
                    <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        <p class="font-extrabold">Alasan penolakan</p>
                        <p class="mt-1">{{ $submission->rejection_reason }}</p>
                    </div>
                @endif
                @if ($submission->order->status === 'awaiting_payment')
                    <x-ui.button :href="route('payments.pay', $submission->order)" class="mt-6 w-full">Bayar Sekarang</x-ui.button>
                @endif
            </x-ui.card>
        </div>
    </div>
@endsection
