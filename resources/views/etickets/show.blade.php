@extends('layouts.public')

@section('title', 'E-ticket')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header & Tombol Cetak --}}
        <div class="mb-6 flex flex-wrap items-center justify-between gap-4 screen-only">
            <x-ui.page-header
                title="E-ticket Resmi"
                subtitle="Tunjukkan barcode QR code ini kepada petugas di loket masuk The Nice Park Rumpin."
            />
            <x-ui.button type="button" variant="secondary" onclick="window.print()">
                <x-ui.icon name="printer" class="size-5" />
                <span>Cetak E-ticket</span>
            </x-ui.button>
        </div>

        {{-- Kartu Tiket Horizontal dengan Garis Sobekan Putus-Putus --}}
        <article id="ticket-print" class="overflow-hidden rounded-2xl border border-line bg-white shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-12">
                {{-- Panel Kiri: primary-900 (Hijau Tua) --}}
                <section class="bg-primary-900 p-6 text-cream sm:p-8 md:col-span-5 flex flex-col justify-between">
                    <div>
                        <p class="font-display text-2xl font-bold text-white">The Nice <span class="text-sunny-400">Park</span></p>
                        <p class="mt-1 text-xs text-cream/70">Wisata Edukasi & Rekreasi Rumpin</p>

                        <div class="mt-8">
                            <span class="text-xs font-semibold uppercase tracking-wider text-sunny-400">Kode E-Ticket</span>
                            <p class="mt-1 font-mono text-2xl font-bold tracking-wider text-white break-all">
                                {{ $order->eTicket->ticket_code }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-white/10 pt-4 text-xs text-cream/70 space-y-1">
                        <p>Kode Pesanan: <span class="font-semibold text-white">{{ $order->order_code }}</span></p>
                        <p>Diterbitkan: {{ $order->eTicket->issued_at?->translatedFormat('d M Y, H:i') ?? '-' }}</p>
                    </div>
                </section>

                {{-- Panel Kanan: Putih dengan Garis Sobekan Putus-Putus --}}
                <section class="relative border-t-2 border-dashed border-line p-6 sm:p-8 md:col-span-7 md:border-l-2 md:border-t-0 bg-white">
                    <span class="ticket-hole -left-3.5 -top-3.5 hidden md:block" aria-hidden="true"></span>
                    <span class="ticket-hole -bottom-3.5 -left-3.5 hidden md:block" aria-hidden="true"></span>

                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Pemegang Tiket</span>
                            <p class="font-display text-xl font-bold text-ink">{{ $order->user->name }}</p>
                            <p class="text-xs text-ink-soft mt-0.5">{{ $order->user->phone ?? $order->user->email }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Tanggal Kunjungan</span>
                            <p class="text-sm font-bold text-primary-700">{{ $order->visit_date->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-line pt-4">
                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Daftar Tiket / Paket</span>
                        <ul class="mt-2 space-y-1 text-sm text-ink">
                            @foreach ($order->items as $item)
                                <li class="flex justify-between gap-3">
                                    <span>{{ $item->ticket?->name ?? $item->schoolPackage?->name ?? 'Tiket Masuk' }}</span>
                                    <span class="font-bold">× {{ number_format($item->quantity, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-6 flex flex-col items-center justify-center border-t border-line pt-6">
                        <div class="rounded-xl border border-line p-2 bg-white shadow-xs">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(130)->generate($order->eTicket->ticket_code) !!}
                        </div>
                        <p class="mt-2 text-center text-xs text-ink-soft">Arahkan QR code ke pemindai di pintu masuk taman.</p>
                    </div>
                </section>
            </div>
        </article>
    </div>
@endsection

@push('scripts')
    <style>
        .ticket-hole {
            position: absolute;
            z-index: 10;
            width: 1.75rem;
            height: 1.75rem;
            border-radius: 9999px;
            background: #FFFDF0;
            border: 1px solid #E4EBDD;
        }
        @media print {
            body { background: white !important; }
            body * { visibility: hidden; }
            #ticket-print, #ticket-print * { visibility: visible; }
            #ticket-print {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                border: 1px solid #E4EBDD;
                box-shadow: none;
            }
            .screen-only, header, footer { display: none !important; }
        }
    </style>
@endpush
