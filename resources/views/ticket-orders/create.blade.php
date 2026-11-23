@extends('layouts.public')

@section('title', 'Pesan Tiket')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <x-ui.page-header title="Pesan Tiket" subtitle="Tentukan tanggal dan jumlah tiket untuk petualanganmu." />
        <div x-data="{ quantity: {{ (int) old('quantity', 1) }}, price: {{ (float) $ticket->price }} }" class="mt-8 grid grid-cols-1 items-start gap-6 lg:grid-cols-5">
            <x-ui.card class="lg:col-span-3">
                <form method="POST" action="{{ route('ticket-orders.store') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                    <div class="rounded-2xl bg-primary-50 p-4">
                        <p class="font-display text-xl font-extrabold">{{ $ticket->name }}</p>
                        <p class="mt-1 font-bold text-primary-700">Rp {{ number_format($ticket->price, 0, ',', '.') }} / tiket</p>
                    </div>
                    <div class="space-y-6">
                        <x-ui.field name="quantity" label="Jumlah Tiket" hint="Pilih 1 sampai 50 tiket.">
                            <div class="flex max-w-xs items-center gap-3">
                                <button type="button" class="min-h-11 min-w-11 rounded-full bg-primary-100 text-xl font-extrabold text-primary-900" @click="quantity = Math.max(1, Number(quantity) - 1)" aria-label="Kurangi jumlah">−</button>
                                <input id="quantity" name="quantity" type="number" min="1" max="50" x-model.number="quantity" value="{{ old('quantity', 1) }}" required class="min-h-11 w-full rounded-xl border-2 border-primary-100 text-center font-bold focus:border-primary-500 focus:ring-primary-100">
                                <button type="button" class="min-h-11 min-w-11 rounded-full bg-primary-100 text-xl font-extrabold text-primary-900" @click="quantity = Math.min(50, Number(quantity) + 1)" aria-label="Tambah jumlah">+</button>
                            </div>
                        </x-ui.field>
                        <x-ui.field name="visit_date" label="Tanggal Kunjungan">
                            <input id="visit_date" name="visit_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('visit_date') }}" required class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
                        </x-ui.field>
                        <x-ui.button type="submit" class="w-full">Lanjutkan ke Pembayaran</x-ui.button>
                    </div>
                </form>
            </x-ui.card>
            <x-ui.card class="bg-gradient-to-br from-sunny-50 to-white lg:col-span-2">
                <p class="text-3xl">🧾</p>
                <h2 class="mt-3 font-display text-2xl font-extrabold">Ringkasan Pesanan</h2>
                <p class="mt-4 text-sm text-primary-800/75">{{ $ticket->name }}</p>
                <div class="mt-5 flex items-center justify-between border-t border-primary-100 pt-4">
                    <span class="font-bold">Estimasi total</span>
                    <span class="font-display text-2xl font-extrabold text-primary-600">Rp <span x-text="(Number(quantity || 1) * price).toLocaleString('id-ID')"></span></span>
                </div>
                <p class="mt-3 text-xs text-primary-800/65">Total akhir dihitung ulang oleh server.</p>
            </x-ui.card>
        </div>
    </div>
@endsection
