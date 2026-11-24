@extends('layouts.public')

@section('title', $ticket->name)

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Breadcrumb ringkas --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-ink-soft" aria-label="Breadcrumb">
            <a href="{{ route('catalog.index') }}" class="hover:text-primary-700">Beranda</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}#tiket" class="hover:text-primary-700">Tiket</a>
            <span>/</span>
            <span class="font-semibold text-ink">{{ $ticket->name }}</span>
        </nav>

        {{-- Layout dua kolom: kiri detail, kanan ringkasan sticky --}}
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            <div class="space-y-6 lg:col-span-7">
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <span class="inline-flex items-center gap-1 rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-semibold text-primary-800">
                        <x-ui.icon name="ticket" class="size-3.5 text-primary-600" />
                        <span>Tiket Masuk Reguler</span>
                    </span>
                    <h1 class="mt-3 font-display text-3xl font-bold text-ink sm:text-4xl">{{ $ticket->name }}</h1>
                    
                    <div class="mt-6">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-ink-soft">Deskripsi Tiket</h2>
                        <p class="mt-2 text-base text-ink leading-relaxed">{{ $ticket->description }}</p>
                    </div>

                    <hr class="my-6 border-line">

                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wider text-ink-soft">Ketentuan Kunjungan</h2>
                        <ul class="mt-3 space-y-2 text-sm text-ink-soft">
                            <li class="flex items-start gap-2">
                                <x-ui.icon name="clock" class="size-4 shrink-0 text-primary-600 mt-0.5" />
                                <span>Jam operasional: Weekday 09.00–17.45 WIB, Weekend 08.00–17.45 WIB.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-ui.icon name="calendar" class="size-4 shrink-0 text-primary-600 mt-0.5" />
                                <span>Tiket berlaku sesuai tanggal kunjungan yang dipilih pada formulir pemesanan.</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <x-ui.icon name="check-circle" class="size-4 shrink-0 text-primary-600 mt-0.5" />
                                <span>E-ticket langsung terbit dengan QR code setelah pembayaran sukses terverifikasi.</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div>
                    <a href="{{ route('catalog.index') }}#tiket" class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary-700 hover:text-primary-800">
                        <x-ui.icon name="arrow-left" class="size-4" />
                        <span>Kembali ke pilihan tiket</span>
                    </a>
                </div>
            </div>

            {{-- Kartu Ringkasan Sticky di Kanan --}}
            <div class="lg:sticky lg:top-24 lg:col-span-5">
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink">Ringkasan Pembelian</h3>
                    <div class="mt-4 rounded-xl bg-cream p-4 border border-line">
                        <span class="text-xs text-ink-soft">Harga tiket per orang</span>
                        <p class="font-display text-3xl font-bold text-primary-700">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                    </div>

                    <div class="mt-6">
                        @if (auth()->user()?->isAdmin())
                            <x-ui.info-box variant="sunny">
                                Akun administrator tidak dapat melakukan transaksi pemesanan tiket.
                            </x-ui.info-box>
                        @else
                            <x-ui.button :href="route('ticket-orders.create', $ticket)" class="w-full">Pesan Tiket Sekarang</x-ui.button>
                        @endif
                    </div>

                    <p class="mt-4 text-center text-xs text-ink-soft">Pembayaran aman dengan QRIS, Virtual Account, & E-Wallet.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
