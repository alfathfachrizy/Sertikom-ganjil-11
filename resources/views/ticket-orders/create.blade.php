@extends('layouts.public')

@section('title', 'Pesan Tiket')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <x-ui.page-header
            title="Formulir Pemesanan Tiket"
            subtitle="Tentukan tanggal kunjungan dan jumlah tiket reguler Anda."
        />

        <div x-data="{ quantity: {{ (int) old('quantity', 1) }}, price: {{ (float) $ticket->price }} }" class="mt-8 grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            {{-- Kolom Kiri: Form Pemesanan --}}
            <div class="lg:col-span-7">
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <form method="POST" action="{{ route('ticket-orders.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

                        <div class="rounded-xl border border-line bg-primary-50 p-4">
                            <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Tiket yang Dipilih</span>
                            <p class="font-display text-xl font-bold text-ink">{{ $ticket->name }}</p>
                            <p class="mt-1 text-sm font-semibold text-primary-700">Rp {{ number_format($ticket->price, 0, ',', '.') }} <span class="font-normal text-ink-soft">/ tiket</span></p>
                        </div>

                        <x-ui.field name="quantity" label="Jumlah Tiket" hint="Pilih antara 1 sampai 50 tiket per transaksi.">
                            <div class="flex max-w-xs items-center gap-2">
                                <button
                                    type="button"
                                    class="flex size-11 items-center justify-center rounded-xl border border-line bg-cream font-bold text-ink transition hover:bg-primary-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-600"
                                    @click="quantity = Math.max(1, Number(quantity) - 1)"
                                    aria-label="Kurangi tiket"
                                >
                                    <x-ui.icon name="minus" class="size-4" />
                                </button>
                                <input
                                    id="quantity"
                                    name="quantity"
                                    type="number"
                                    min="1"
                                    max="50"
                                    x-model.number="quantity"
                                    value="{{ old('quantity', 1) }}"
                                    required
                                    class="h-11 w-full rounded-xl border border-line bg-white text-center font-bold text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
                                >
                                <button
                                    type="button"
                                    class="flex size-11 items-center justify-center rounded-xl border border-line bg-cream font-bold text-ink transition hover:bg-primary-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-600"
                                    @click="quantity = Math.min(50, Number(quantity) + 1)"
                                    aria-label="Tambah tiket"
                                >
                                    <x-ui.icon name="plus" class="size-4" />
                                </button>
                            </div>
                        </x-ui.field>

                        <x-ui.field name="visit_date" label="Tanggal Kunjungan" hint="Pilih tanggal kedatangan ke The Nice Park Rumpin.">
                            <input
                                id="visit_date"
                                name="visit_date"
                                type="date"
                                min="{{ now()->toDateString() }}"
                                value="{{ old('visit_date') }}"
                                required
                                class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
                            >
                        </x-ui.field>

                        <div class="pt-2">
                            <x-ui.button type="submit" class="w-full">Lanjutkan ke Pembayaran</x-ui.button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Kolom Kanan: Ringkasan Sticky --}}
            <div class="lg:sticky lg:top-24 lg:col-span-5">
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-2">
                        <x-ui.icon name="receipt" class="size-5 text-primary-600" />
                        <h2 class="font-display text-lg font-bold text-ink">Ringkasan Pemesanan</h2>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-ink-soft">
                        <div class="flex justify-between">
                            <span>Jenis Tiket</span>
                            <span class="font-semibold text-ink">{{ $ticket->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Harga Satuan</span>
                            <span>Rp {{ number_format($ticket->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Jumlah</span>
                            <span><span x-text="Number(quantity || 1)"></span> tiket</span>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-line pt-4">
                        <div class="flex items-baseline justify-between">
                            <span class="font-bold text-ink">Total Estimasi</span>
                            <span class="font-display text-2xl font-bold text-primary-700">
                                Rp <span x-text="(Number(quantity || 1) * price).toLocaleString('id-ID')"></span>
                            </span>
                        </div>
                    </div>

                    <p class="mt-4 text-xs text-ink-soft leading-relaxed">
                        Perhitungan akhir akan divalidasi oleh sistem saat pembayaran dibuat.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
