@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <x-ui.page-header
        title="Ringkasan Operasional"
        subtitle="Pantau metrik penjualan tiket, reservasi rombongan sekolah, dan arus pendapatan."
    />

    {{-- 4 Kartu Statistik Seragam: angka besar, label kecil, ikon kecil SVG seragam --}}
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['receipt', 'Total Pesanan Masuk', number_format($totalOrders, 0, ',', '.'), 'bg-primary-50 text-primary-700'],
            ['check-circle', 'Pesanan Telah Lunas', number_format($paidOrders, 0, ',', '.'), 'bg-primary-100 text-primary-800'],
            ['hourglass', 'Pengajuan Menunggu', number_format($pendingSubmissions, 0, ',', '.'), 'bg-sunny-100 text-ink'],
            ['credit-card', 'Akumulasi Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'), 'bg-primary-50 text-primary-700'],
        ] as [$icon, $label, $value, $badgeColor])
            <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">{{ $label }}</span>
                        <p class="font-display text-2xl font-bold text-ink break-words">{{ $value }}</p>
                    </div>
                    <div class="flex size-10 shrink-0 items-center justify-center rounded-xl {{ $badgeColor }}">
                        <x-ui.icon :name="$icon" class="size-5" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Akses Cepat Kelola --}}
    <div class="mt-10 rounded-2xl border border-line bg-white p-6 shadow-sm">
        <h2 class="font-display text-lg font-bold text-ink">Akses Cepat Pengelolaan</h2>
        <p class="mt-1 text-sm text-ink-soft leading-relaxed">Pintasan ke halaman antrean persetujuan dan rekapitulasi data transaksi pelanggan.</p>
        <div class="mt-6 flex flex-wrap items-center gap-3">
            <x-ui.button :href="route('admin.school-submissions.index')">
                <x-ui.icon name="school" class="size-4" />
                <span>Tinjau Pengajuan Sekolah</span>
            </x-ui.button>
            <x-ui.button variant="secondary" :href="route('admin.orders.index')">
                <x-ui.icon name="receipt" class="size-4" />
                <span>Lihat Seluruh Pesanan</span>
            </x-ui.button>
            <x-ui.button variant="ghost" :href="route('admin.tickets.index')">
                <x-ui.icon name="ticket" class="size-4" />
                <span>Kelola Tiket</span>
            </x-ui.button>
        </div>
    </div>
@endsection
