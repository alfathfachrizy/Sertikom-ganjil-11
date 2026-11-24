@extends('layouts.public')

@section('title', 'Status Pengajuan')

@section('content')
    @php
        $status = $submission->order->status;
        // Stepper: 0 = Diajukan, 1 = Ditinjau Admin, 2 = Pembayaran, 3 = E-ticket
        // selesai = hijau, saat ini = kuning, belum = abu
        $activeStep = match ($status) {
            'paid' => 3,
            'awaiting_payment' => 2,
            'rejected' => 1,
            default => 1,
        };
        $steps = ['Diajukan', 'Ditinjau Admin', 'Pembayaran', 'E-ticket'];
    @endphp

    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <x-ui.page-header
            title="Status Pengajuan Sekolah"
            subtitle="Pantau proses persetujuan dan kelanjutan pemesanan rombongan Anda."
        />

        {{-- Stepper 4 Langkah Horizontal yang Tegas --}}
        <div class="mt-8 rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between border-b border-line pb-4">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">ID Pengajuan #{{ $submission->id }}</span>
                    <h2 class="font-display text-xl font-bold text-ink">{{ $submission->school_name }}</h2>
                </div>
                <x-ui.status-badge :status="$submission->status" />
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4 sm:grid-cols-4">
                @foreach ($steps as $index => $step)
                    @php
                        $isCompleted = ($status === 'paid' && $index <= 3) || ($status !== 'rejected' && $index < $activeStep);
                        $isCurrent = ($index === $activeStep);

                        $stepStyle = match (true) {
                            $isCompleted => 'bg-primary-600 text-white border-primary-600',
                            $isCurrent => 'bg-sunny-400 text-ink border-sunny-500 font-bold',
                            default => 'bg-gray-100 text-gray-500 border-gray-200',
                        };
                    @endphp
                    <div class="flex flex-col items-center text-center">
                        <div class="flex size-10 items-center justify-center rounded-full border text-sm font-bold {{ $stepStyle }}">
                            @if ($isCompleted)
                                <x-ui.icon name="check-circle" class="size-5" />
                            @else
                                <span>{{ $index + 1 }}</span>
                            @endif
                        </div>
                        <p class="mt-2 text-xs font-bold {{ $isCurrent ? 'text-ink' : ($isCompleted ? 'text-primary-800' : 'text-ink-soft') }}">
                            {{ $step }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Alasan Penolakan Jika Ditolak --}}
        @if ($submission->status === 'rejected' && $submission->rejection_reason)
            <div class="mt-6">
                <x-ui.info-box variant="danger" icon="x-circle">
                    <div>
                        <p class="font-bold text-red-900">Pengajuan Belum Dapat Disetujui</p>
                        <p class="mt-1 text-sm text-red-800 leading-relaxed">{{ $submission->rejection_reason }}</p>
                    </div>
                </x-ui.info-box>
            </div>
        @endif

        {{-- Detail Data Rombongan & Ringkasan --}}
        <div class="mt-6 grid grid-cols-1 items-start gap-8 md:grid-cols-2">
            <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                <h3 class="font-display text-lg font-bold text-ink border-b border-line pb-3">Data Rombongan</h3>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between gap-3">
                        <dt class="text-ink-soft">Nama Sekolah</dt>
                        <dd class="text-right font-semibold text-ink break-words max-w-xs">{{ $submission->school_name }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-ink-soft">Penanggung Jawab</dt>
                        <dd class="text-right font-semibold text-ink">{{ $submission->pic_name }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-ink-soft">Nomor Telepon</dt>
                        <dd class="text-right font-semibold text-ink">{{ $submission->pic_phone }}</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-ink-soft">Jumlah Peserta</dt>
                        <dd class="text-right font-semibold text-ink">{{ number_format($submission->participant_count, 0, ',', '.') }} orang</dd>
                    </div>
                    <div class="flex justify-between gap-3">
                        <dt class="text-ink-soft">Tanggal Kunjungan</dt>
                        <dd class="text-right font-semibold text-ink">{{ $submission->order->visit_date->translatedFormat('d F Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-line bg-white p-6 shadow-sm flex flex-col justify-between">
                <div>
                    <h3 class="font-display text-lg font-bold text-ink border-b border-line pb-3">Ringkasan Tagihan</h3>
                    <p class="mt-3 text-xs text-ink-soft">Kode: {{ $submission->order->order_code }}</p>
                    <div class="mt-4 space-y-2 text-sm">
                        @foreach ($submission->order->items as $item)
                            <div class="flex justify-between gap-3">
                                <span class="text-ink-soft">{{ $item->schoolPackage?->name }} × {{ $item->quantity }}</span>
                                <span class="font-semibold text-ink">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 border-t border-line pt-4 flex justify-between items-baseline">
                        <span class="font-bold text-ink">Total Biaya</span>
                        <span class="font-display text-2xl font-bold text-primary-700">Rp {{ number_format($submission->order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-line">
                    @if ($submission->order->status === 'awaiting_payment')
                        <x-ui.button :href="route('payments.pay', $submission->order)" class="w-full">
                            <span>Lanjutkan ke Pembayaran</span>
                        </x-ui.button>
                    @elseif ($submission->order->status === 'paid' && $submission->order->eTicket)
                        <x-ui.button variant="secondary" :href="route('etickets.show', $submission->order)" class="w-full">
                            <x-ui.icon name="qr-code" class="size-4" />
                            <span>Lihat E-Ticket</span>
                        </x-ui.button>
                    @else
                        <x-ui.button variant="ghost" :href="route('orders.show', $submission->order)" class="w-full">
                            <span>Lihat Status Pesanan</span>
                        </x-ui.button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
