@extends('layouts.public')

@section('title', $package->name)

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <nav class="mb-6 text-sm font-semibold text-primary-700" aria-label="Breadcrumb">
            <a href="{{ route('catalog.index') }}" class="hover:underline">Beranda</a>
            <span class="px-2">/</span><a href="{{ route('catalog.index') }}#paket-sekolah" class="hover:underline">Paket Sekolah</a>
            <span class="px-2">/</span><span class="text-primary-900">{{ $package->name }}</span>
        </nav>
        <x-ui.card class="overflow-hidden p-0">
            <div class="bg-gradient-to-r from-primary-600 to-primary-500 px-6 py-10 text-white sm:px-10">
                <span class="text-5xl">🎒</span>
                <h1 class="mt-4 font-display text-3xl font-extrabold sm:text-5xl">{{ $package->name }}</h1>
                <p class="mt-3 font-display text-4xl font-extrabold text-sunny-300">Rp {{ number_format($package->price_per_participant, 0, ',', '.') }} <span class="font-sans text-lg">/ peserta</span></p>
                <span class="mt-4 inline-flex rounded-full bg-white/15 px-4 py-2 font-bold">Minimal {{ $package->min_participants }} peserta</span>
            </div>
            <div class="grid gap-8 p-6 sm:p-10 md:grid-cols-2">
                <div>
                    <h2 class="font-display text-2xl font-extrabold">Tentang Paket</h2>
                    <p class="mt-3 leading-7 text-primary-800/80">{{ $package->description }}</p>
                    <h3 class="mt-6 font-display text-xl font-extrabold">Fasilitas</h3>
                    <ul class="mt-3 space-y-2 text-primary-800">
                        <li>🎟️ Tiket masuk</li>
                        <li>🛝 Akses playground</li>
                        <li>🦓 Akses mini zoo</li>
                    </ul>
                </div>
                <div class="rounded-2xl bg-sunny-50 p-5">
                    <h2 class="font-display text-xl font-extrabold">Alur Pengajuan</h2>
                    <p class="mt-3 leading-7 text-primary-800/80">Pengajuan rombongan akan ditinjau admin terlebih dahulu. Pembayaran dibuka setelah pengajuan disetujui.</p>
                    <p class="mt-3 font-bold text-primary-800">Minimal {{ $package->min_participants }} peserta.</p>
                </div>
            </div>
            <div class="flex flex-col gap-3 border-t border-primary-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-10">
                <a href="{{ route('catalog.index') }}#paket-sekolah" class="min-h-11 inline-flex items-center font-bold text-primary-700 hover:underline">← Kembali ke paket</a>
                @if (auth()->user()?->isAdmin())
                    <p class="rounded-2xl bg-sunny-50 px-4 py-3 text-sm font-semibold text-primary-800">Admin tidak dapat memesan paket.</p>
                @else
                    <x-ui.button :href="route('school-submissions.create', $package)">Ajukan Paket</x-ui.button>
                @endif
            </div>
        </x-ui.card>
    </div>
@endsection
