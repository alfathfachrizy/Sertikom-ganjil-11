@extends('layouts.public')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <x-ui.page-header title="Detail Pesanan" :subtitle="$order->order_code" />
            <x-ui.status-badge :status="$order->status" class="self-start sm:self-auto" />
        </div>
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <x-ui.card class="lg:col-span-2">
                <h2 class="font-display text-2xl font-extrabold">Rincian Item</h2>
                <div class="mt-5 overflow-x-auto">
                    <table class="w-full min-w-[560px] text-left text-sm">
                        <thead class="border-b border-primary-100 text-primary-700">
                            <tr><th class="py-3 pr-4">Nama</th><th class="py-3 pr-4">Jumlah</th><th class="py-3 pr-4">Harga satuan</th><th class="py-3 text-right">Subtotal</th></tr>
                        </thead>
                        <tbody class="divide-y divide-primary-50">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="py-4 pr-4 font-bold">{{ $item->ticket?->name ?? $item->schoolPackage?->name ?? 'Item tidak tersedia' }}</td>
                                    <td class="py-4 pr-4">{{ number_format($item->quantity, 0, ',', '.') }}</td>
                                    <td class="py-4 pr-4">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                    <td class="py-4 text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot><tr class="border-t-2 border-primary-100"><th colspan="3" class="py-4 text-right">Total</th><th class="py-4 text-right font-display text-lg text-primary-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th></tr></tfoot>
                    </table>
                </div>
                <div class="mt-5 grid grid-cols-1 gap-3 rounded-2xl bg-primary-50 p-4 text-sm sm:grid-cols-2">
                    <p><span class="text-primary-700">Jenis:</span> <strong>{{ $order->order_type === 'school' ? 'Paket Sekolah' : 'Tiket Umum' }}</strong></p>
                    <p><span class="text-primary-700">Tanggal kunjungan:</span> <strong>{{ $order->visit_date->translatedFormat('d F Y') }}</strong></p>
                </div>
            </x-ui.card>
            <x-ui.card>
                <h2 class="font-display text-xl font-extrabold">Aksi Pesanan</h2>
                <div class="mt-5 flex flex-col gap-3">
                    @if ($order->status === 'awaiting_payment')
                        <x-ui.button :href="route('payments.pay', $order)" class="w-full">Bayar Sekarang</x-ui.button>
                    @endif
                    @if ($order->status === 'paid' && $order->eTicket)
                        <x-ui.button variant="secondary" :href="route('etickets.show', $order)" class="w-full">Lihat E-ticket</x-ui.button>
                    @endif
                    @if ($order->schoolSubmission)
                        <x-ui.button variant="ghost" :href="route('school-submissions.show', $order->schoolSubmission)" class="w-full">Lihat Pengajuan Sekolah</x-ui.button>
                    @endif
                    <x-ui.button variant="ghost" :href="route('orders.index')" class="w-full">Kembali ke Pesanan</x-ui.button>
                </div>
            </x-ui.card>
            <x-ui.card class="lg:col-span-3">
                <h2 class="font-display text-xl font-extrabold">Riwayat Pembayaran</h2>
                @if ($order->payments->isNotEmpty())
                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
                        @foreach ($order->payments as $payment)
                            <div class="rounded-2xl bg-primary-50 p-4">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    @php($paymentLabel = ['settlement' => 'Lunas', 'pending' => 'Menunggu Pembayaran', 'expire' => 'Kedaluwarsa', 'cancel' => 'Dibatalkan', 'deny' => 'Ditolak', 'capture' => 'Diproses'][$payment->transaction_status] ?? $payment->transaction_status)
                                    <span @class(['inline-flex min-h-8 items-center rounded-full px-3 py-1 text-xs font-extrabold', 'bg-primary-100 text-primary-800' => $payment->transaction_status === 'settlement', 'bg-orange-100 text-orange-800' => $payment->transaction_status === 'pending', 'bg-gray-100 text-gray-700' => ! in_array($payment->transaction_status, ['settlement', 'pending'], true)])>{{ $paymentLabel }}</span>
                                    <span class="text-sm font-bold">{{ $payment->payment_type ? str($payment->payment_type)->replace('_', ' ')->title() : 'Metode belum dipilih' }}</span>
                                </div>
                                <p class="mt-2 text-xs text-primary-700">Diperbarui {{ $payment->updated_at->translatedFormat('d F Y, H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-3 text-sm text-primary-700">Belum ada pembayaran.</p>
                @endif
            </x-ui.card>
        </div>
    </div>
@endsection
