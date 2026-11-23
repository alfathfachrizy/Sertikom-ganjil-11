@extends('layouts.public')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <x-ui.page-header title="Pesanan Saya" subtitle="Lihat status dan rincian kunjungan yang sudah Anda pesan." />
        @if ($orders->isNotEmpty())
            <div class="mt-8 grid grid-cols-1 gap-4">
                @foreach ($orders as $order)
                    <x-ui.card class="transition hover:-translate-y-1">
                        <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                            <div class="min-w-0">
                                <div class="flex flex-wrap items-center gap-3">
                                    <h2 class="font-display text-xl font-extrabold">{{ $order->order_code }}</h2>
                                    <x-ui.status-badge :status="$order->status" />
                                </div>
                                <p class="mt-2 text-sm text-primary-700">{{ $order->order_type === 'school' ? 'Paket Sekolah' : 'Tiket Umum' }} · Kunjungan {{ $order->visit_date->translatedFormat('d F Y') }}</p>
                                @if ($order->schoolSubmission)
                                    <p class="mt-1 text-sm font-semibold text-primary-800">{{ $order->schoolSubmission->school_name }}</p>
                                @endif
                            </div>
                            <div class="flex items-center justify-between gap-4 md:justify-end">
                                <p class="font-display text-xl font-extrabold text-primary-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                <x-ui.button :href="route('orders.show', $order)">Detail</x-ui.button>
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
            <div class="mt-7">{{ $orders->links() }}</div>
        @else
            <x-ui.empty-state class="mt-8" title="Belum ada pesanan" message="Yuk pilih tiket atau ajukan paket sekolah untuk memulai keseruan." href="{{ route('catalog.index') }}" button="Lihat Tiket" emoji="🎟️" />
        @endif
    </div>
@endsection
