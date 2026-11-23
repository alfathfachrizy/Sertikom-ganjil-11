@extends('layouts.public')

@section('title', $ticket->name)

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm font-semibold text-primary-700" aria-label="Breadcrumb">
            <a href="{{ route('catalog.index') }}" class="hover:underline">Beranda</a>
            <span class="px-2">/</span><a href="{{ route('catalog.index') }}#tiket" class="hover:underline">Tiket</a>
            <span class="px-2">/</span><span class="text-primary-900">{{ $ticket->name }}</span>
        </nav>
        <x-ui.card class="overflow-hidden p-0">
            <div class="bg-gradient-to-r from-primary-600 to-primary-500 px-6 py-10 text-white sm:px-10">
                <span class="text-5xl">🎟️</span>
                <h1 class="mt-4 font-display text-3xl font-extrabold sm:text-5xl">{{ $ticket->name }}</h1>
                <p class="mt-3 font-display text-4xl font-extrabold text-sunny-300">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
            </div>
            <div class="grid gap-8 p-6 sm:p-10 md:grid-cols-2">
                <div>
                    <h2 class="font-display text-2xl font-extrabold">Tentang Tiket</h2>
                    <p class="mt-3 leading-7 text-primary-800/80">{{ $ticket->description }}</p>
                </div>
                <div class="rounded-2xl bg-primary-50 p-5">
                    <h2 class="font-display text-xl font-extrabold">Ketentuan Kunjungan</h2>
                    <ul class="mt-3 list-inside list-disc space-y-2 text-sm leading-6 text-primary-800">
                        <li>Weekday buka pukul 09.00–17.45.</li>
                        <li>Weekend dan hari libur buka pukul 08.00–17.45.</li>
                        <li>Tiket berlaku sesuai tanggal kunjungan yang dipilih.</li>
                        <li>E-ticket terbit setelah pembayaran terverifikasi.</li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col gap-3 border-t border-primary-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-10">
                <a href="{{ route('catalog.index') }}#tiket" class="min-h-11 inline-flex items-center font-bold text-primary-700 hover:underline">← Kembali ke tiket</a>
                @if (auth()->user()?->isAdmin())
                    <p class="rounded-2xl bg-sunny-50 px-4 py-3 text-sm font-semibold text-primary-800">Admin tidak dapat memesan tiket.</p>
                @else
                    <x-ui.button :href="route('ticket-orders.create', $ticket)">Pesan Tiket</x-ui.button>
                @endif
            </div>
        </x-ui.card>
    </div>
@endsection
