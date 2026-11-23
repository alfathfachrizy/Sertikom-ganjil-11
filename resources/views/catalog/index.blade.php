@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
    <section class="relative isolate overflow-hidden bg-gradient-to-br from-primary-600 via-primary-500 to-primary-700 text-white">
        <div class="pointer-events-none absolute -right-10 top-4 h-56 w-56 rounded-full bg-sunny-300/80 sm:right-20 sm:h-72 sm:w-72" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-16 left-1/4 h-48 w-48 rounded-full bg-primary-300/40" aria-hidden="true"></div>
        <div class="relative mx-auto grid max-w-7xl grid-cols-1 items-center gap-8 px-4 py-16 sm:px-6 sm:py-24 lg:grid-cols-2 lg:px-8">
            <div class="max-w-2xl">
                <span class="inline-flex rounded-full bg-white/15 px-4 py-2 text-sm font-bold text-sunny-100">🌿 Waktunya bermain dan belajar!</span>
                <h1 class="mt-5 font-display text-4xl font-extrabold leading-tight sm:text-6xl">Main Sepuasnya di The Nice Park Rumpin!</h1>
                <p class="mt-5 max-w-xl text-lg text-white/90">Ajak keluarga menikmati wahana seru, satwa lucu, dan pengalaman menyenangkan di alam terbuka.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <x-ui.button variant="secondary" href="#tiket">Lihat Tiket</x-ui.button>
                    <x-ui.button href="#paket-sekolah" class="!bg-white !text-primary-800 hover:!bg-primary-50">Pesan Paket Sekolah</x-ui.button>
                </div>
                <div class="mt-7 flex flex-wrap gap-3 text-sm font-bold">
                    <span class="rounded-full bg-primary-900/30 px-4 py-2">🕘 Weekday 09.00–17.45</span>
                    <span class="rounded-full bg-orange-500 px-4 py-2 font-extrabold text-white">🎉 Diskon HTM Rp 35.000</span>
                </div>
            </div>
            <div class="relative hidden min-h-72 items-center justify-center lg:flex" aria-hidden="true">
                <div class="absolute h-64 w-64 rounded-full border-[18px] border-white/30"></div>
                <div class="relative flex h-48 w-48 items-center justify-center rounded-full bg-sunny-300 text-8xl shadow-2xl">🎡</div>
                <span class="absolute right-8 top-8 text-5xl">🌈</span>
                <span class="absolute bottom-8 left-12 text-5xl">🦒</span>
            </div>
        </div>
        <svg class="absolute bottom-0 h-12 w-full translate-y-px" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true"><path fill="#FFFDF0" d="M0,32 C180,78 360,0 540,35 C720,70 900,10 1080,38 C1260,66 1370,20 1440,35 L1440,80 L0,80 Z"></path></svg>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="font-bold uppercase tracking-widest text-primary-600">Banyak keseruan menanti</p>
            <h2 class="mt-2 font-display text-3xl font-extrabold text-primary-900 sm:text-4xl">Kenapa Main di The Nice?</h2>
        </div>
        <div class="mt-9 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['🌈', 'Rainbow Slide', 'Meluncur seru dengan warna-warni yang ceria.'],
                ['🦓', 'Mini Zoo', 'Kenalan lebih dekat dengan satwa yang menggemaskan.'],
                ['🛝', 'Playground', 'Bebaskan energi si kecil di area bermain.'],
                ['🍜', 'Kuliner', 'Isi kembali tenaga dengan pilihan makanan lezat.'],
            ] as [$emoji, $title, $description])
                <x-ui.card class="transition hover:-translate-y-1">
                    <div class="text-4xl">{{ $emoji }}</div>
                    <h3 class="mt-4 font-display text-xl font-extrabold">{{ $title }}</h3>
                    <p class="mt-2 text-sm text-primary-800/75">{{ $description }}</p>
                </x-ui.card>
            @endforeach
        </div>
    </section>

    <section id="tiket" class="scroll-mt-24 bg-primary-50/70 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-ui.page-header title="Pilih Tiket Bermain" subtitle="Pilih tiket yang paling pas untuk hari seru bersama keluarga.">
                <x-slot name="actions">
                    <span class="rounded-full bg-sunny-200 px-4 py-2 text-sm font-extrabold text-primary-900">🎟️ Harga mulai Rp 20.000</span>
                </x-slot>
            </x-ui.page-header>
            @if ($tickets->isNotEmpty())
                <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($tickets as $ticket)
                        <x-ui.card class="flex flex-col transition hover:-translate-y-1">
                            <span class="text-4xl">🎫</span>
                            <h3 class="mt-4 font-display text-2xl font-extrabold">{{ $ticket->name }}</h3>
                            <p class="mt-2 flex-1 text-primary-800/75">{{ \Illuminate\Support\Str::limit($ticket->description, 110) }}</p>
                            <p class="mt-5 font-display text-3xl font-extrabold text-primary-600">Rp {{ number_format($ticket->price, 0, ',', '.') }}</p>
                            <x-ui.button :href="route('catalog.ticket', $ticket)" class="mt-5 w-full">Lihat Detail</x-ui.button>
                        </x-ui.card>
                    @endforeach
                </div>
            @else
                <x-ui.empty-state class="mt-8" title="Tiket segera hadir" message="Tiket belum tersedia. Silakan kembali lagi nanti." emoji="🎟️" />
            @endif
        </div>
    </section>

    <section id="paket-sekolah" class="scroll-mt-24 mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <x-ui.page-header title="Paket Sekolah & Rombongan" subtitle="Belajar di luar kelas dengan kegiatan seru untuk seluruh siswa.">
            <x-slot name="actions">
                <span class="rounded-full bg-sunny-200 px-4 py-2 text-sm font-extrabold text-primary-900">📚 Minimal 20 peserta</span>
            </x-slot>
        </x-ui.page-header>
        @if ($packages->isNotEmpty())
            <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($packages as $package)
                    <x-ui.card class="flex flex-col transition hover:-translate-y-1">
                        <span class="text-4xl">🎒</span>
                        <h3 class="mt-4 font-display text-2xl font-extrabold">{{ $package->name }}</h3>
                        <p class="mt-2 flex-1 text-primary-800/75">{{ \Illuminate\Support\Str::limit($package->description, 120) }}</p>
                        <span class="mt-4 w-fit rounded-full bg-sunny-100 px-3 py-1 text-sm font-bold">Min. {{ $package->min_participants }} peserta</span>
                        <p class="mt-4 font-display text-3xl font-extrabold text-primary-600">Rp {{ number_format($package->price_per_participant, 0, ',', '.') }} <span class="font-sans text-sm font-bold">/ peserta</span></p>
                        <x-ui.button :href="route('catalog.package', $package)" class="mt-5 w-full">Lihat Detail</x-ui.button>
                    </x-ui.card>
                @endforeach
            </div>
        @else
            <x-ui.empty-state class="mt-8" title="Paket sekolah segera hadir" message="Paket rombongan belum tersedia saat ini." emoji="🎒" />
        @endif
    </section>

    <section class="bg-gradient-to-r from-sunny-100 via-cream to-primary-100 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="font-bold uppercase tracking-widest text-primary-600">Mudah dan praktis</p>
                <h2 class="mt-2 font-display text-3xl font-extrabold text-primary-900 sm:text-4xl">Cara Memesan</h2>
            </div>
            <div class="mt-9 grid grid-cols-1 gap-5 md:grid-cols-3">
                @foreach ([['1', 'Pilih', 'Pilih tiket atau paket yang sesuai.'], ['2', 'Bayar', 'Selesaikan pembayaran dengan aman.'], ['3', 'E-ticket', 'Tunjukkan e-ticket saat berkunjung.']] as [$number, $title, $description])
                    <x-ui.card class="text-center">
                        <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-primary-600 font-display text-2xl font-extrabold text-white">{{ $number }}</span>
                        <h3 class="mt-4 font-display text-2xl font-extrabold">{{ $title }}</h3>
                        <p class="mt-2 text-primary-800/75">{{ $description }}</p>
                    </x-ui.card>
                @endforeach
            </div>
            <p class="mx-auto mt-5 max-w-3xl rounded-2xl bg-white/80 px-5 py-4 text-center text-sm text-primary-800">Paket sekolah: Ajukan paket → Menunggu persetujuan admin → Bayar → E-ticket terbit.</p>
        </div>
    </section>
@endsection
