@extends('layouts.admin')

@section('title', 'Daftar Pesanan & Transaksi')

@section('content')
    <x-ui.page-header
        title="Daftar Pesanan & Transaksi"
        subtitle="Kelola pesanan tiket masuk reguler dan transaksi paket rombongan sekolah."
    />

    {{-- Filter Status (Segmented Control / Tab Sederhana) --}}
    <div class="mt-6 flex flex-wrap gap-2">
        @foreach ([
            ['value' => '', 'label' => 'Semua'],
            ['value' => 'pending_approval', 'label' => 'Menunggu Persetujuan'],
            ['value' => 'awaiting_payment', 'label' => 'Menunggu Pembayaran'],
            ['value' => 'paid', 'label' => 'Lunas'],
            ['value' => 'rejected', 'label' => 'Ditolak'],
            ['value' => 'expired', 'label' => 'Kedaluwarsa'],
            ['value' => 'cancelled', 'label' => 'Dibatalkan'],
        ] as $filter)
            <a
                href="{{ route('admin.orders.index', $filter['value'] !== '' ? ['status' => $filter['value']] : []) }}"
                @class([
                    'inline-flex min-h-[38px] items-center rounded-full px-4 text-xs font-bold transition duration-150',
                    'bg-primary-700 text-white shadow-xs' => request('status', '') === $filter['value'],
                    'bg-white text-ink border border-line hover:bg-primary-50' => request('status', '') !== $filter['value'],
                ])
            >
                {{ $filter['label'] }}
            </a>
        @endforeach
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-line bg-white shadow-sm">
        @if ($orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] text-left text-sm">
                    <thead class="sticky top-0 bg-primary-50/60 text-xs font-bold uppercase tracking-wider text-ink-soft border-b border-line">
                        <tr>
                            <th scope="col" class="px-6 py-4">Kode Transaksi</th>
                            <th scope="col" class="px-6 py-4">Nama Pelanggan</th>
                            <th scope="col" class="px-6 py-4">Jenis Pesanan</th>
                            <th scope="col" class="px-6 py-4">Tanggal Kunjungan</th>
                            <th scope="col" class="px-6 py-4 text-right">Total Tagihan</th>
                            <th scope="col" class="px-6 py-4 text-center">Status Pesanan</th>
                            <th scope="col" class="px-6 py-4 text-center">Status Pembayaran</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($orders as $order)
                            @php
                                $lastPayment = $order->payments->sortByDesc('id')->first();
                            @endphp
                            <tr class="transition hover:bg-cream/40">
                                <td class="whitespace-nowrap px-6 py-4 font-bold text-ink">
                                    {{ $order->order_code }}
                                </td>
                                <td class="px-6 py-4 text-ink">
                                    <p class="font-semibold">{{ $order->user->name }}</p>
                                    <p class="text-xs text-ink-soft">{{ $order->user->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-ink-soft">
                                    {{ $order->order_type === 'school' ? 'Paket Rombongan Sekolah' : 'Tiket Reguler' }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-ink-soft">
                                    {{ $order->visit_date->translatedFormat('d F Y') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right font-bold text-ink">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <x-ui.status-badge :status="$order->status" />
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-center text-xs">
                                    @if ($lastPayment)
                                        @php
                                            $paymentLabel = [
                                                'settlement' => 'Lunas',
                                                'pending' => 'Menunggu Pembayaran',
                                                'expire' => 'Kedaluwarsa',
                                                'cancel' => 'Dibatalkan',
                                                'deny' => 'Ditolak',
                                                'capture' => 'Diproses',
                                            ][$lastPayment->transaction_status] ?? $lastPayment->transaction_status;
                                        @endphp
                                        <span class="font-semibold text-ink">{{ $paymentLabel }}</span>
                                    @else
                                        <span class="text-ink-soft">—</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <x-ui.button variant="ghost" size="sm" :href="route('admin.orders.show', $order)">
                                        <span>Rincian</span>
                                        <x-ui.icon name="arrow-right" class="size-4" />
                                    </x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="border-t border-line px-6 py-4">
                {{ $orders->links() }}
            </div>
        @else
            <div class="p-8">
                <x-ui.empty-state
                    title="Belum ada transaksi pesanan"
                    message="Daftar pesanan pengunjung yang masuk akan ditampilkan pada tabel ini."
                    icon="receipt"
                />
            </div>
        @endif
    </div>
@endsection
