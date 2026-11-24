@extends('layouts.public')

@section('title', 'Beranda')

@section('content')
    {{-- Hero Section dengan Background Foto + Dark Overlay Elegan --}}
    <section class="relative isolate overflow-hidden border-b border-primary-950 bg-primary-950">
        {{-- Gambar Latar Belakang --}}
        <img
            src="{{ asset('images/hero-banner.jpg') }}"
            alt="The Nice Park Rumpin"
            class="absolute inset-0 -z-20 h-full w-full object-cover object-center filter brightness-60"
        >

        {{-- Lapisan Dark Gradient Overlay: memastikan teks sangat jelas dan kontras tinggi --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-primary-950/95 via-primary-950/80 to-primary-900/60" aria-hidden="true"></div>

        <div class="relative mx-auto grid max-w-6xl grid-cols-1 items-center gap-12 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-12 lg:px-8">
            {{-- Konten Utama Hero (Kiri) --}}
            <div class="lg:col-span-7">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3.5 py-1 text-xs font-bold text-sunny-300 backdrop-blur-md border border-white/15 shadow-xs">
                    <x-ui.icon name="sun" class="size-3.5 text-sunny-400" />
                    <span>Wisata Edukasi & Rekreasi Keluarga</span>
                </span>

                <h1 class="mt-5 font-display text-4xl font-bold tracking-tight text-white sm:text-5xl lg:text-6xl leading-[1.15]">
                    Main sepuasnya di <span class="text-sunny-400">The Nice Park</span> Rumpin!
                </h1>

                <p class="mt-5 max-w-xl text-base text-cream/90 sm:text-lg leading-relaxed">
                    Nikmati sensasi Rainbow Slide, taman bermain anak yang luas, dan serunya interaksi satwa di alam terbuka yang asri dan ramah keluarga.
                </p>

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <x-ui.button href="#tiket" class="shadow-md">
                        <x-ui.icon name="ticket" class="size-4" />
                        <span>Pesan Tiket Sekarang</span>
                    </x-ui.button>
                    <x-ui.button variant="secondary" href="#paket-sekolah" class="shadow-md">
                        <x-ui.icon name="school" class="size-4" />
                        <span>Paket Rombongan Sekolah</span>
                    </x-ui.button>
                </div>
            </div>

            {{-- Kartu Info Cepat Floating di Kanan (Glassmorphism Halus) --}}
            <div class="lg:col-span-5">
                <div class="rounded-2xl border border-white/15 bg-white/10 p-6 sm:p-7 shadow-lg backdrop-blur-md">
                    <div class="space-y-4">
                        <div class="rounded-xl border border-white/20 bg-white/95 p-5 shadow-sm text-ink">
                            <span class="text-xs font-bold uppercase tracking-wider text-ink-soft">Tiket Masuk Reguler</span>
                            <div class="mt-1.5 flex items-baseline gap-2">
                                <span class="font-display text-3xl font-bold text-primary-700">Mulai Rp 35.000</span>
                                <span class="text-xs font-semibold text-ink-soft">/ orang</span>
                            </div>
                            <p class="mt-2 text-xs text-ink-soft leading-relaxed">Sudah termasuk akses area taman terbuka, mini zoo, dan spot foto asri.</p>
                        </div>

                        <div class="rounded-xl border border-white/15 bg-primary-900/80 p-4 text-cream backdrop-blur-xs">
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-sunny-400/20 text-sunny-300">
                                    <x-ui.icon name="clock" class="size-5" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-white">Buka Setiap Hari</p>
                                    <p class="text-xs text-cream/80">Weekday 09.00–17.45 &bull; Weekend 08.00–17.45 WIB</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-xl border border-white/15 bg-primary-900/80 p-4 text-cream backdrop-blur-xs">
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-primary-600/30 text-primary-200">
                                    <x-ui.icon name="map-pin" class="size-5" />
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-bold text-white">Lokasi Wisata</p>
                                    <p class="text-xs text-cream/80 truncate">Kp Cisirung, Kec. Rumpin, Kab. Bogor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Strip Info 3 Kolom Tipis dengan Ikon SVG --}}
    <section class="border-b border-line bg-white">
        <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 divide-y divide-line sm:grid-cols-3 sm:divide-x sm:divide-y-0">
                <div class="flex items-center gap-3 py-3 sm:px-4 sm:py-0">
                    <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-700">
                        <x-ui.icon name="clock" class="size-5" />
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Jam Kunjungan</p>
                        <p class="text-sm font-bold text-ink">Weekday 09.00–17.45 &bull; Weekend 08.00</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 py-3 sm:px-4 sm:py-0">
                    <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-700">
                        <x-ui.icon name="map-pin" class="size-5" />
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Lokasi Taman</p>
                        <p class="text-sm font-bold text-ink">Kp Cisirung, Rumpin, Bogor 16350</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 py-3 sm:px-4 sm:py-0">
                    <div class="flex size-9 shrink-0 items-center justify-center rounded-lg bg-primary-50 text-primary-700">
                        <x-ui.icon name="users" class="size-5" />
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Paket Sekolah</p>
                        <p class="text-sm font-bold text-ink">Rombongan minimal 20 orang</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Section Wahana (Daftar teks + ikon bersih) --}}
    <section class="mx-auto max-w-6xl px-4 py-12 sm:px-6 md:py-16 lg:px-8">
        <x-ui.section-heading
            title="Wahana & Fasilitas Utama"
            description="Berbagai pilihan aktivitas seru yang dirancang khusus untuk kenyamanan keluarga dan siswa."
        />

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['rainbow-slide.webp', 'ticket', 'Rainbow Slide', 'Seluncuran warna-warni yang memacu keceriaan seluruh pengunjung.'],
                ['mini-zoo.webp', 'users', 'Mini Zoo', 'Area interaksi satwa jinak yang aman dan edukatif bagi anak-anak.'],
                ['playground.jpg', 'sparkles', 'Playground', 'Area bermain terbuka dengan fasilitas ramah balita hingga anak-anak.'],
                ['kuliner.webp', 'sun', 'Area Kuliner', 'Pusat jajanan dan santapan keluarga yang higienis dan terjangkau.'],
            ] as [$image, $icon, $title, $description])
                <div class="group flex flex-col overflow-hidden rounded-2xl border border-line bg-white shadow-sm transition hover:border-primary-200">
                    <div class="relative h-44 w-full overflow-hidden bg-primary-50">
                        <img
                            src="{{ asset('images/' . $image) }}"
                            alt="{{ $title }}"
                            class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                            loading="lazy"
                        >
                    </div>
                    <div class="flex flex-1 flex-col p-5">
                        <div class="flex items-center gap-2">
                            <div class="flex size-7 items-center justify-center rounded-lg bg-primary-50 text-primary-700">
                                <x-ui.icon :name="$icon" class="size-4" />
                            </div>
                            <h3 class="font-display text-lg font-bold text-ink">{{ $title }}</h3>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-ink-soft">{{ $description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Section Tiket Masuk --}}
    <section id="tiket" class="scroll-mt-20 border-y border-line bg-primary-50/50 py-12 md:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <x-ui.section-heading
                    title="Pilihan Tiket Masuk"
                    description="Pesan tiket masuk reguler secara online untuk akses masuk lebih cepat tanpa antre."
                />
            </div>

            @if ($tickets->isNotEmpty())
                <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($tickets as $ticket)
                        <div class="flex flex-col rounded-2xl border border-line bg-white p-6 shadow-sm transition hover:border-primary-100">
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center gap-1 rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-semibold text-primary-800">
                                    <x-ui.icon name="ticket" class="size-3.5 text-primary-600" />
                                    <span>Tiket Masuk</span>
                                </span>
                            </div>
                            <h3 class="mt-4 font-display text-xl font-bold text-ink">{{ $ticket->name }}</h3>
                            <p class="mt-2 line-clamp-2 text-sm text-ink-soft leading-relaxed">{{ $ticket->description }}</p>

                            <div class="mt-6 pt-4 border-t border-line">
                                <span class="text-xs text-ink-soft">Harga tiket</span>
                                <p class="font-display text-2xl font-bold text-primary-700">
                                    Rp {{ number_format($ticket->price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="mt-auto pt-6">
                                <x-ui.button :href="route('catalog.ticket', $ticket)" class="w-full">Lihat Rincian</x-ui.button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="mt-8">
                    <x-ui.empty-state title="Tiket belum tersedia" message="Daftar tiket bermain akan segera diperbarui. Silakan periksa kembali nanti." />
                </div>
            @endif
        </div>
    </section>

    {{-- Section Paket Sekolah --}}
    <section id="paket-sekolah" class="scroll-mt-20 mx-auto max-w-6xl px-4 py-12 sm:px-6 md:py-16 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <x-ui.section-heading
                title="Paket Rombongan Sekolah"
                description="Program kunjungan edukatif luar ruangan dengan harga khusus untuk rombongan sekolah."
            />
            <span class="inline-flex items-center gap-1 rounded-full bg-sunny-100 px-3 py-1 text-xs font-semibold text-ink border border-line">
                <x-ui.icon name="school" class="size-4 text-primary-900" />
                <span>Minimal 20 peserta</span>
            </span>
        </div>

        @if ($packages->isNotEmpty())
            <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($packages as $package)
                    <div class="flex flex-col rounded-2xl border border-line bg-white p-6 shadow-sm transition hover:border-primary-100">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1 rounded-full bg-primary-50 px-2.5 py-0.5 text-xs font-semibold text-primary-800">
                                <x-ui.icon name="school" class="size-3.5 text-primary-600" />
                                <span>Paket Sekolah</span>
                            </span>
                            <span class="text-xs text-ink-soft">Min. {{ $package->min_participants }} anak</span>
                        </div>

                        <h3 class="mt-4 font-display text-xl font-bold text-ink">{{ $package->name }}</h3>
                        <p class="mt-2 line-clamp-2 text-sm text-ink-soft leading-relaxed">{{ $package->description }}</p>

                        <div class="mt-6 pt-4 border-t border-line">
                            <span class="text-xs text-ink-soft">Biaya per peserta</span>
                            <div class="flex items-baseline gap-1">
                                <span class="font-display text-2xl font-bold text-primary-700">Rp {{ number_format($package->price_per_participant, 0, ',', '.') }}</span>
                                <span class="text-xs text-ink-soft">/ peserta</span>
                            </div>
                        </div>

                        <div class="mt-auto pt-6">
                            <x-ui.button :href="route('catalog.package', $package)" class="w-full">Pelajari Paket</x-ui.button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-8">
                <x-ui.empty-state title="Paket sekolah belum tersedia" message="Program paket rombongan sekolah saat ini sedang dalam persiapan." icon="school" />
            </div>
        @endif
    </section>

    {{-- Section Cara Memesan (Dua alur langkah bernomor ringan) --}}
    <section class="border-t border-line bg-cream py-12 md:py-16">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <x-ui.section-heading
                title="Panduan Pemesanan"
                description="Alur mudah pemesanan tiket reguler maupun pengajuan kunjungan rombongan sekolah."
            />

            <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Alur Tiket Umum --}}
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink flex items-center gap-2">
                        <x-ui.icon name="ticket" class="size-5 text-primary-600" />
                        <span>Pemesanan Tiket Umum</span>
                    </h3>
                    <div class="mt-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-primary-50 font-bold text-xs text-primary-700">1</span>
                            <div>
                                <p class="text-sm font-bold text-ink">Pilih Tiket & Tanggal</p>
                                <p class="text-xs text-ink-soft leading-relaxed">Tentukan jenis tiket, jumlah tiket, dan tanggal kedatangan Anda.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-primary-50 font-bold text-xs text-primary-700">2</span>
                            <div>
                                <p class="text-sm font-bold text-ink">Bayar Instan</p>
                                <p class="text-xs text-ink-soft leading-relaxed">Selesaikan transaksi aman menggunakan metode pembayaran Midtrans.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-primary-50 font-bold text-xs text-primary-700">3</span>
                            <div>
                                <p class="text-sm font-bold text-ink">Terima E-Ticket</p>
                                <p class="text-xs text-ink-soft leading-relaxed">E-ticket langsung terbit dengan QR code untuk dipindai di pintu masuk.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Alur Paket Sekolah --}}
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink flex items-center gap-2">
                        <x-ui.icon name="school" class="size-5 text-primary-600" />
                        <span>Pengajuan Paket Sekolah</span>
                    </h3>
                    <div class="mt-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-sunny-100 font-bold text-xs text-ink">1</span>
                            <div>
                                <p class="text-sm font-bold text-ink">Isi Formulir Rombongan</p>
                                <p class="text-xs text-ink-soft leading-relaxed">Kirimkan nama sekolah, kontak penanggung jawab, dan estimasi peserta.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-sunny-100 font-bold text-xs text-ink">2</span>
                            <div>
                                <p class="text-sm font-bold text-ink">Konfirmasi Admin</p>
                                <p class="text-xs text-ink-soft leading-relaxed">Admin memeriksa ketersediaan slot kunjungan rombongan Anda.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex size-7 shrink-0 items-center justify-center rounded-full bg-sunny-100 font-bold text-xs text-ink">3</span>
                            <div>
                                <p class="text-sm font-bold text-ink">Pelunasan & E-Ticket</p>
                                <p class="text-xs text-ink-soft leading-relaxed">Setelah disetujui, selesaikan pembayaran dan e-ticket rombongan terbit.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
