@extends('layouts.public')

@section('title', $package->name)

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Breadcrumb ringkas --}}
        <nav class="mb-6 flex items-center gap-2 text-sm text-ink-soft" aria-label="Breadcrumb">
            <a href="{{ route('catalog.index') }}" class="hover:text-primary-700">Beranda</a>
            <span>/</span>
            <a href="{{ route('catalog.index') }}#paket-sekolah" class="hover:text-primary-700">Paket Sekolah</a>
            <span>/</span>
            <span class="font-semibold text-ink">{{ $package->name }}</span>
        </nav>

        {{-- Layout dua kolom: kiri detail, kanan ringkasan sticky --}}
        <div class="grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            <div class="space-y-6 lg:col-span-7">
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center gap-1 rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-semibold text-primary-800">
                            <x-ui.icon name="school" class="size-3.5 text-primary-600" />
                            <span>Paket Edukasi Rombongan</span>
                        </span>
                        <span class="rounded-full bg-sunny-100 border border-line px-2.5 py-0.5 text-xs font-semibold text-ink">
                            Minimal {{ $package->min_participants }} peserta
                        </span>
                    </div>

                    <h1 class="mt-3 font-display text-3xl font-bold text-ink sm:text-4xl">{{ $package->name }}</h1>

                    <div class="mt-6">
                        <h2 class="text-sm font-bold uppercase tracking-wider text-ink-soft">Deskripsi Program</h2>
                        <p class="mt-2 text-base text-ink leading-relaxed">{{ $package->description }}</p>
                    </div>

                    <hr class="my-6 border-line">

                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wider text-ink-soft">Fasilitas yang Termasuk</h2>
                        <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <div class="flex items-center gap-2 text-sm text-ink-soft">
                                <x-ui.icon name="check-circle" class="size-4 shrink-0 text-primary-600" />
                                <span>Tiket masuk seluruh area</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-ink-soft">
                                <x-ui.icon name="check-circle" class="size-4 shrink-0 text-primary-600" />
                                <span>Akses playground anak</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-ink-soft">
                                <x-ui.icon name="check-circle" class="size-4 shrink-0 text-primary-600" />
                                <span>Akses edukasi mini zoo</span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-ink-soft">
                                <x-ui.icon name="check-circle" class="size-4 shrink-0 text-primary-600" />
                                <span>Pendamping rombongan</span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-6 border-line">

                    <div>
                        <h2 class="text-sm font-bold uppercase tracking-wider text-ink-soft">Proses Pengajuan Kunjungan</h2>
                        <div class="mt-3 space-y-2 text-sm text-ink-soft">
                            <p class="flex items-start gap-2">
                                <x-ui.icon name="hourglass" class="size-4 shrink-0 text-sunny-600 mt-0.5" />
                                <span>Pengajuan rombongan sekolah ditinjau oleh tim admin dalam 1x24 jam.</span>
                            </p>
                            <p class="flex items-start gap-2">
                                <x-ui.icon name="credit-card" class="size-4 shrink-0 text-primary-600 mt-0.5" />
                                <span>Tautan pembayaran online akan dibuka segera setelah pengajuan dinyatakan disetujui.</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div>
                    <a href="{{ route('catalog.index') }}#paket-sekolah" class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary-700 hover:text-primary-800">
                        <x-ui.icon name="arrow-left" class="size-4" />
                        <span>Kembali ke pilihan paket sekolah</span>
                    </a>
                </div>
            </div>

            {{-- Kartu Ringkasan Sticky di Kanan --}}
            <div class="lg:sticky lg:top-24 lg:col-span-5">
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink">Ringkasan Paket</h3>
                    <div class="mt-4 rounded-xl bg-cream p-4 border border-line">
                        <span class="text-xs text-ink-soft">Biaya per peserta</span>
                        <div class="flex items-baseline gap-1">
                            <span class="font-display text-3xl font-bold text-primary-700">Rp {{ number_format($package->price_per_participant, 0, ',', '.') }}</span>
                            <span class="text-xs text-ink-soft">/ peserta</span>
                        </div>
                        <p class="mt-2 text-xs text-ink-soft">Syarat rombongan: Minimal {{ $package->min_participants }} peserta terdaftar.</p>
                    </div>

                    <div class="mt-6">
                        @if (auth()->user()?->isAdmin())
                            <x-ui.info-box variant="sunny">
                                Akun administrator tidak dapat mengajukan paket sekolah.
                            </x-ui.info-box>
                        @else
                            <x-ui.button :href="route('school-submissions.create', $package)" class="w-full">Ajukan Kunjungan Sekolah</x-ui.button>
                        @endif
                    </div>

                    <p class="mt-4 text-center text-xs text-ink-soft">Verifikasi ketersediaan tanggal sebelum pembayaran.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
