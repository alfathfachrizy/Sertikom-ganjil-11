@extends('layouts.public')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header dengan badge status --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <x-ui.page-header
                title="Rincian Pesanan"
                :subtitle="'Kode Transaksi: ' . $order->order_code"
            />
            <x-ui.status-badge :status="$order->status" class="self-start sm:self-auto" />
        </div>

        <div class="mt-8 grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            {{-- Bagian Kiri: Tabel Item & Info Kunjungan --}}
            <div class="space-y-6 lg:col-span-8">
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <h2 class="font-display text-xl font-bold text-ink">Item yang Dipesan</h2>
                    
                    <div class="mt-4 overflow-x-auto">
                        <table class="w-full min-w-[500px] text-left text-sm">
                            <thead class="border-b border-line text-xs font-bold uppercase tracking-wider text-ink-soft">
                                <tr>
                                    <th scope="col" class="pb-3 pr-4">Nama Produk</th>
                                    <th scope="col" class="pb-3 pr-4 text-center">Jumlah</th>
                                    <th scope="col" class="pb-3 pr-4 text-right">Harga Satuan</th>
                                    <th scope="col" class="pb-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-line">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="py-4 pr-4 font-semibold text-ink">
                                            {{ $item->ticket?->name ?? $item->schoolPackage?->name ?? 'Produk tidak tersedia' }}
                                        </td>
                                        <td class="py-4 pr-4 text-center text-ink-soft">
                                            {{ number_format($item->quantity, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 pr-4 text-right text-ink-soft">
                                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                        </td>
                                        <td class="py-4 text-right font-bold text-ink">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-line">
                                    <th colspan="3" class="pt-4 text-right font-bold text-ink">Total Pembayaran</th>
                                    <th class="pt-4 text-right font-display text-xl font-bold text-primary-700">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 rounded-xl border border-line bg-cream p-4 text-sm sm:grid-cols-2">
                        <div>
                            <span class="text-xs text-ink-soft">Jenis Pesanan</span>
                            <p class="font-bold text-ink">{{ $order->order_type === 'school' ? 'Paket Rombongan Sekolah' : 'Tiket Masuk Reguler' }}</p>
                        </div>
                        <div>
                            <span class="text-xs text-ink-soft">Tanggal Kunjungan</span>
                            <p class="font-bold text-ink">{{ $order->visit_date->translatedFormat('d F Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Riwayat Pembayaran (Daftar Vertikal Garis Waktu Sederhana) --}}
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <h2 class="font-display text-xl font-bold text-ink">Riwayat Pembayaran</h2>
                    @if ($order->payments->isNotEmpty())
                        <div class="mt-4 space-y-3">
                            @foreach ($order->payments as $payment)
                                <div class="flex items-center justify-between rounded-xl border border-line p-4 text-sm">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            @php
                                                $paymentLabel = [
                                                    'settlement' => 'Lunas',
                                                    'pending' => 'Menunggu Pembayaran',
                                                    'expire' => 'Kedaluwarsa',
                                                    'cancel' => 'Dibatalkan',
                                                    'deny' => 'Ditolak',
                                                    'capture' => 'Diproses',
                                                ][$payment->transaction_status] ?? $payment->transaction_status;

                                                $paymentBadgeClass = match ($payment->transaction_status) {
                                                    'settlement', 'capture' => 'bg-primary-100 text-primary-900 border-primary-200',
                                                    'pending' => 'bg-sunny-100 text-ink border-line',
                                                    'expire', 'cancel', 'deny' => 'bg-gray-100 text-gray-700 border-gray-200',
                                                    default => 'bg-gray-100 text-gray-700 border-gray-200',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold {{ $paymentBadgeClass }}">
                                                {{ $paymentLabel }}
                                            </span>
                                            <span class="font-bold text-ink">
                                                {{ $payment->payment_type ? str($payment->payment_type)->replace('_', ' ')->title() : 'Metode belum dipilih' }}
                                            </span>
                                        </div>
                                        <p class="text-xs text-ink-soft">ID: {{ $payment->midtrans_order_id }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-ink">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</span>
                                        <p class="text-xs text-ink-soft">{{ $payment->updated_at->translatedFormat('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-sm text-ink-soft">Belum ada transaksi pembayaran yang tercatat.</p>
                    @endif
                </div>
            </div>

            {{-- Bagian Kanan: Aksi Pesanan --}}
            <div class="space-y-4 lg:sticky lg:top-24 lg:col-span-4">
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink">Aksi Pesanan</h3>
                    <div class="mt-4 flex flex-col gap-3">
                        @if ($order->status === 'awaiting_payment')
                            <x-ui.button :href="route('payments.pay', $order)" class="w-full">Bayar Sekarang</x-ui.button>
                        @endif

                        @if ($order->status === 'paid' && $order->eTicket)
                            <x-ui.button variant="secondary" :href="route('etickets.show', $order)" class="w-full">
                                <x-ui.icon name="qr-code" class="size-4" />
                                <span>Buka E-Ticket</span>
                            </x-ui.button>
                        @endif

                        @if ($order->schoolSubmission)
                            <x-ui.button variant="ghost" :href="route('school-submissions.show', $order->schoolSubmission)" class="w-full">
                                <span>Status Pengajuan Sekolah</span>
                            </x-ui.button>
                        @endif

                        <x-ui.button variant="ghost" :href="route('orders.index')" class="w-full">
                            <x-ui.icon name="arrow-left" class="size-4" />
                            <span>Kembali ke Pesanan Saya</span>
                        </x-ui.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
