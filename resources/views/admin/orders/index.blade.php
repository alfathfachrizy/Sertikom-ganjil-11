@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
    <x-ui.page-header title="Pesanan" subtitle="Pantau transaksi dan status kunjungan pelanggan." />
    <div class="mt-6 flex flex-wrap gap-2">
        @foreach ([['value' => '', 'label' => 'Semua'], ['value' => 'pending_approval', 'label' => 'Menunggu Persetujuan'], ['value' => 'awaiting_payment', 'label' => 'Menunggu Pembayaran'], ['value' => 'paid', 'label' => 'Lunas'], ['value' => 'rejected', 'label' => 'Ditolak'], ['value' => 'expired', 'label' => 'Kedaluwarsa'], ['value' => 'cancelled', 'label' => 'Dibatalkan']] as $filter)
            <a href="{{ route('admin.orders.index', $filter['value'] !== '' ? ['status' => $filter['value']] : []) }}" @class(['inline-flex min-h-11 items-center rounded-full px-4 py-2 text-sm font-bold', 'bg-primary-600 text-white' => request('status', '') === $filter['value'], 'bg-white text-primary-800 ring-1 ring-primary-100 hover:bg-primary-50' => request('status', '') !== $filter['value']])>{{ $filter['label'] }}</a>
        @endforeach
    </div>
    <x-ui.card class="mt-5 p-0">
        @if ($orders->isNotEmpty())
            <div class="overflow-x-auto rounded-3xl">
                <table class="w-full min-w-[1050px] text-left text-sm">
                    <thead class="bg-primary-50 text-primary-800"><tr><th class="px-5 py-4">Kode</th><th class="px-5 py-4">Pelanggan</th><th class="px-5 py-4">Jenis</th><th class="px-5 py-4">Tanggal Kunjungan</th><th class="px-5 py-4">Total</th><th class="px-5 py-4">Status Pesanan</th><th class="px-5 py-4">Pembayaran Terakhir</th><th class="px-5 py-4"></th></tr></thead>
                    <tbody class="divide-y divide-primary-50">
                        @foreach ($orders as $order)
                            @php($lastPayment = $order->payments->sortByDesc('id')->first())
                            <tr class="hover:bg-cream">
                                <td class="whitespace-nowrap px-5 py-4 font-bold">{{ $order->order_code }}</td>
                                <td class="px-5 py-4">{{ $order->user->name }}</td>
                                <td class="px-5 py-4">{{ $order->order_type === 'school' ? 'Paket Sekolah' : 'Tiket Umum' }}</td>
                                <td class="whitespace-nowrap px-5 py-4">{{ $order->visit_date->translatedFormat('d F Y') }}</td>
                                <td class="whitespace-nowrap px-5 py-4 font-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="px-5 py-4"><x-ui.status-badge :status="$order->status" /></td>
                                <td class="px-5 py-4">
                                    @if ($lastPayment)
                                        @php($paymentLabel = ['settlement' => 'Lunas', 'pending' => 'Menunggu Pembayaran', 'expire' => 'Kedaluwarsa', 'cancel' => 'Dibatalkan', 'deny' => 'Ditolak', 'capture' => 'Diproses'][$lastPayment->transaction_status] ?? $lastPayment->transaction_status)
                                        <span class="font-semibold">{{ $paymentLabel }}</span>
                                    @else
                                        <span class="text-primary-700">Belum ada</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right"><x-ui.button :href="route('admin.orders.show', $order)">Detail</x-ui.button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4">{{ $orders->links() }}</div>
        @else
            <div class="p-5"><x-ui.empty-state title="Pesanan belum tersedia" message="Pesanan pelanggan akan tampil di sini." emoji="🧾" /></div>
        @endif
    </x-ui.card>
@endsection
