@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <x-ui.page-header title="Dashboard" subtitle="Ringkasan aktivitas The Nice Park hari ini." />
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['🧾', 'Total Pesanan', number_format($totalOrders, 0, ',', '.'), 'bg-primary-100'],
            ['🎉', 'Pesanan Lunas', number_format($paidOrders, 0, ',', '.'), 'bg-sunny-100'],
            ['🏫', 'Pengajuan Menunggu', number_format($pendingSubmissions, 0, ',', '.'), 'bg-orange-100'],
            ['💰', 'Total Pendapatan', 'Rp '.number_format($totalRevenue, 0, ',', '.'), 'bg-primary-200'],
        ] as [$emoji, $label, $value, $color])
            <x-ui.card class="transition hover:-translate-y-1">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-bold text-primary-700">{{ $label }}</p>
                        <p class="mt-3 break-words font-display text-2xl font-extrabold text-primary-900">{{ $value }}</p>
                    </div>
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl {{ $color }} text-2xl">{{ $emoji }}</span>
                </div>
            </x-ui.card>
        @endforeach
    </div>
    <div class="mt-8">
        <h2 class="font-display text-2xl font-extrabold">Akses Cepat</h2>
        <div class="mt-4 flex flex-wrap gap-3">
            <x-ui.button :href="route('admin.school-submissions.index')">📝 Tinjau Pengajuan Sekolah</x-ui.button>
            <x-ui.button variant="secondary" :href="route('admin.orders.index')">🧾 Lihat Pesanan</x-ui.button>
        </div>
    </div>
@endsection
