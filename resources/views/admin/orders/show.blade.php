@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <x-ui.page-header
            title="Rincian Pesanan"
            :subtitle="'Kode Transaksi: ' . $order->order_code"
        />
        <x-ui.status-badge :status="$order->status" class="self-start sm:self-auto" />
    </div>

    <div class="mt-8 grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
        {{-- Data Pemesan & Rincian Item di Kiri --}}
        <div class="space-y-6 lg:col-span-8">
            <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                <h2 class="font-display text-xl font-bold text-ink border-b border-line pb-3">Informasi Pemesan</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Nama Pemesan</dt>
                        <dd class="mt-1 font-bold text-ink">{{ $order->user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Alamat Email</dt>
                        <dd class="mt-1 font-bold text-ink break-all">{{ $order->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Jenis Pesanan</dt>
                        <dd class="mt-1 font-semibold text-ink">{{ $order->order_type === 'school' ? 'Paket Rombongan Sekolah' : 'Tiket Masuk Reguler' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Tanggal Kunjungan</dt>
                        <dd class="mt-1 font-bold text-primary-700">{{ $order->visit_date->translatedFormat('d F Y') }}</dd>
                    </div>
                </dl>

                <h3 class="mt-8 border-t border-line pt-6 font-display text-lg font-bold text-ink">Daftar Item</h3>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full min-w-[500px] text-left text-sm">
                        <thead class="border-b border-line text-xs font-bold uppercase tracking-wider text-ink-soft">
                            <tr>
                                <th scope="col" class="pb-3">Nama Item</th>
                                <th scope="col" class="pb-3 text-center">Jumlah</th>
                                <th scope="col" class="pb-3 text-right">Harga Satuan</th>
                                <th scope="col" class="pb-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-line">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="py-3.5 font-semibold text-ink">
                                        {{ $item->ticket?->name ?? $item->schoolPackage?->name ?? 'Produk tidak tersedia' }}
                                    </td>
                                    <td class="py-3.5 text-center text-ink-soft">
                                        {{ number_format($item->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 text-right text-ink-soft">
                                        Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3.5 text-right font-bold text-ink">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-line">
                                <th colspan="3" class="pt-4 text-right font-bold text-ink">Total Tagihan</th>
                                <th class="pt-4 text-right font-display text-xl font-bold text-primary-700">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel Samping: Status Terkait di Kanan --}}
        <div class="space-y-6 lg:col-span-4">
            @if ($order->schoolSubmission)
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink border-b border-line pb-3">Pengajuan Sekolah</h3>
                    <p class="mt-3 font-bold text-ink">{{ $order->schoolSubmission->school_name }}</p>
                    <p class="mt-1 text-xs text-ink-soft">{{ $order->schoolSubmission->pic_name }} &bull; {{ number_format($order->schoolSubmission->participant_count, 0, ',', '.') }} peserta</p>
                    <div class="mt-3">
                        <x-ui.status-badge :status="$order->schoolSubmission->status" />
                    </div>
                    @if ($order->schoolSubmission->rejection_reason)
                        <div class="mt-3 rounded-xl border border-red-200 bg-red-50 p-3 text-xs text-red-800">
                            {{ $order->schoolSubmission->rejection_reason }}
                        </div>
                    @endif
                    <div class="mt-4 pt-3 border-t border-line">
                        <x-ui.button variant="ghost" size="sm" :href="route('admin.school-submissions.show', $order->schoolSubmission)" class="w-full">
                            <span>Buka Detail Pengajuan</span>
                            <x-ui.icon name="arrow-right" class="size-4" />
                        </x-ui.button>
                    </div>
                </div>
            @endif

            <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                <h3 class="font-display text-lg font-bold text-ink border-b border-line pb-3">Riwayat Pembayaran</h3>
                <div class="mt-4 space-y-3">
                    @forelse ($order->payments as $payment)
                        @php
                            $paymentLabel = [
                                'settlement' => 'Lunas',
                                'pending' => 'Menunggu Pembayaran',
                                'expire' => 'Kedaluwarsa',
                                'cancel' => 'Dibatalkan',
                                'deny' => 'Ditolak',
                                'capture' => 'Diproses',
                            ][$payment->transaction_status] ?? $payment->transaction_status;
                        @endphp
                        <div class="rounded-xl border border-line bg-cream p-4 text-xs space-y-1">
                            <div class="flex justify-between items-center font-bold text-ink">
                                <span>{{ $paymentLabel }}</span>
                                <span>Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-ink-soft">{{ $payment->payment_type ? str($payment->payment_type)->replace('_', ' ')->title() : 'Metode belum dipilih' }}</p>
                            <p class="text-ink-soft/70 pt-1">ID: {{ $payment->midtrans_order_id }}</p>
                            <p class="text-ink-soft/70">{{ $payment->updated_at->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-ink-soft">Belum ada pembayaran yang tercatat.</p>
                    @endforelse
                </div>
            </div>

            @if ($order->eTicket)
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink border-b border-line pb-3">E-ticket Diterbitkan</h3>
                    <p class="mt-3 font-mono text-sm font-bold text-primary-700 break-all">{{ $order->eTicket->ticket_code }}</p>
                    <p class="mt-1 text-xs text-ink-soft">Diterbitkan: {{ $order->eTicket->issued_at?->translatedFormat('d M Y, H:i') ?? '-' }}</p>
                </div>
            @endif

            <div>
                <x-ui.button variant="ghost" :href="route('admin.orders.index')" class="w-full">
                    <x-ui.icon name="arrow-left" class="size-4" />
                    <span>Kembali ke Daftar Pesanan</span>
                </x-ui.button>
            </div>
        </div>
    </div>
@endsection
