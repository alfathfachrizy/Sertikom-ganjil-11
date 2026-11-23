@extends('layouts.public')

@section('title', 'E-ticket')

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-4 screen-only">
            <x-ui.page-header title="E-ticket Anda" subtitle="Tunjukkan tiket ini saat tiba di The Nice Park." />
            <x-ui.button type="button" variant="secondary" onclick="window.print()">Cetak E-ticket</x-ui.button>
        </div>
        <article id="ticket-print" class="overflow-hidden rounded-3xl border-2 border-primary-100 bg-white shadow-[0_16px_40px_rgba(17,114,47,0.14)]">
            <div class="grid grid-cols-1 md:grid-cols-[0.9fr_1.1fr]">
                <section class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-900 p-7 text-white sm:p-10">
                    <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-sunny-300/30" aria-hidden="true"></div>
                    <div class="relative">
                        <p class="font-display text-2xl font-extrabold">The Nice <span class="text-sunny-300">Park</span></p>
                        <p class="mt-2 text-sm text-white/80">Tiket kunjungan resmi</p>
                        <div class="mt-12">
                            <p class="text-xs font-bold uppercase tracking-widest text-sunny-200">Kode E-ticket</p>
                            <p class="mt-2 break-all font-display text-3xl font-extrabold sm:text-4xl">{{ $order->eTicket->ticket_code }}</p>
                        </div>
                        <div class="mt-8 border-t border-dashed border-white/40 pt-5">
                            <p class="text-xs font-bold uppercase tracking-widest text-sunny-200">Kode Pesanan</p>
                            <p class="mt-1 font-bold">{{ $order->order_code }}</p>
                        </div>
                    </div>
                </section>
                <section class="relative border-t-2 border-dashed border-primary-200 p-7 md:border-l-2 md:border-t-0 sm:p-10">
                    <span class="ticket-hole -left-4 -top-4 hidden md:block" aria-hidden="true"></span>
                    <span class="ticket-hole -bottom-4 -left-4 hidden md:block" aria-hidden="true"></span>
                    <h1 class="font-display text-2xl font-extrabold text-primary-900">Detail Kunjungan</h1>
                    <dl class="mt-5 space-y-4 text-sm">
                        <div><dt class="text-primary-700">Nama pemesan</dt><dd class="mt-1 font-extrabold">{{ $order->user->name }}</dd></div>
                        <div><dt class="text-primary-700">Tanggal kunjungan</dt><dd class="mt-1 font-extrabold">{{ $order->visit_date->translatedFormat('d F Y') }}</dd></div>
                    </dl>
                    <div class="mt-6 border-t border-primary-100 pt-5">
                        <h2 class="font-bold">Rincian tiket</h2>
                        <ul class="mt-3 space-y-2 text-sm">
                            @foreach ($order->items as $item)
                                <li class="flex justify-between gap-3"><span>{{ $item->ticket?->name ?? $item->schoolPackage?->name ?? 'Tiket kunjungan' }}</span><span class="shrink-0 font-bold">× {{ number_format($item->quantity, 0, ',', '.') }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-7 flex justify-center rounded-2xl bg-white p-3">
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(140)->generate($order->eTicket->ticket_code) !!}
                    </div>
                    <p class="mt-2 text-center text-xs text-primary-700">Pindai kode QR saat pemeriksaan tiket.</p>
                </section>
            </div>
        </article>
    </div>
@endsection

@push('scripts')
    <style>
        .ticket-hole { position: absolute; z-index: 1; width: 2rem; height: 2rem; border-radius: 9999px; background: #FFFDF0; }
        @media print {
            body { background: white !important; }
            body * { visibility: hidden; }
            #ticket-print, #ticket-print * { visibility: visible; }
            #ticket-print { position: absolute; left: 0; top: 0; width: 100%; border-color: #d3f8d8; box-shadow: none; }
            .screen-only, header, footer { display: none !important; }
        }
    </style>
@endpush
