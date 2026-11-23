@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <x-ui.page-header title="Detail Pesanan" :subtitle="$order->order_code" />
        <x-ui.status-badge :status="$order->status" class="self-start sm:self-auto" />
    </div>
    <div class="mt-7 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <x-ui.card class="lg:col-span-2">
            <h2 class="font-display text-xl font-extrabold">Informasi Pemesan</h2>
            <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                <div><dt class="text-primary-700">Nama</dt><dd class="mt-1 font-bold">{{ $order->user->name }}</dd></div>
                <div><dt class="text-primary-700">Email</dt><dd class="mt-1 break-all font-bold">{{ $order->user->email }}</dd></div>
                <div><dt class="text-primary-700">Jenis pesanan</dt><dd class="mt-1 font-bold">{{ $order->order_type === 'school' ? 'Paket Sekolah' : 'Tiket Umum' }}</dd></div>
                <div><dt class="text-primary-700">Tanggal kunjungan</dt><dd class="mt-1 font-bold">{{ $order->visit_date->translatedFormat('d F Y') }}</dd></div>
            </dl>
            <h2 class="mt-7 border-t border-primary-100 pt-5 font-display text-xl font-extrabold">Item Pesanan</h2>
            <div class="mt-4 overflow-x-auto">
                <table class="w-full min-w-[520px] text-left text-sm">
                    <thead class="text-primary-700"><tr><th class="py-2">Nama item</th><th class="py-2">Jumlah</th><th class="py-2">Harga</th><th class="py-2 text-right">Subtotal</th></tr></thead>
                    <tbody class="divide-y divide-primary-50">
                        @foreach ($order->items as $item)
                            <tr><td class="py-3 font-semibold">{{ $item->ticket?->name ?? $item->schoolPackage?->name ?? 'Item tidak tersedia' }}</td><td class="py-3">{{ number_format($item->quantity, 0, ',', '.') }}</td><td class="py-3">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td><td class="py-3 text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <p class="mt-4 text-right font-display text-xl font-extrabold text-primary-700">Total Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
        </x-ui.card>
        <div class="space-y-6">
            @if ($order->schoolSubmission)
                <x-ui.card>
                    <h2 class="font-display text-xl font-extrabold">Pengajuan Sekolah</h2>
                    <p class="mt-3 font-bold">{{ $order->schoolSubmission->school_name }}</p>
                    <p class="mt-1 text-sm text-primary-700">{{ $order->schoolSubmission->pic_name }} · {{ number_format($order->schoolSubmission->participant_count, 0, ',', '.') }} peserta</p>
                    <div class="mt-3"><x-ui.status-badge :status="$order->schoolSubmission->status" /></div>
                    @if ($order->schoolSubmission->rejection_reason)
                        <p class="mt-3 rounded-xl bg-red-50 p-3 text-sm text-red-800">{{ $order->schoolSubmission->rejection_reason }}</p>
                    @endif
                    <x-ui.button variant="ghost" :href="route('admin.school-submissions.show', $order->schoolSubmission)" class="mt-4 w-full">Buka Pengajuan</x-ui.button>
                </x-ui.card>
            @endif
            <x-ui.card>
                <h2 class="font-display text-xl font-extrabold">Riwayat Pembayaran</h2>
                @forelse ($order->payments as $payment)
                    @php($paymentLabel = ['settlement' => 'Lunas', 'pending' => 'Menunggu Pembayaran', 'expire' => 'Kedaluwarsa', 'cancel' => 'Dibatalkan', 'deny' => 'Ditolak', 'capture' => 'Diproses'][$payment->transaction_status] ?? $payment->transaction_status)
                    <div class="mt-4 rounded-2xl bg-primary-50 p-4 text-sm">
                        <p class="font-bold">{{ $paymentLabel }} · Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</p>
                        <p class="mt-1 text-primary-700">{{ $payment->payment_type ? str($payment->payment_type)->replace('_', ' ')->title() : 'Metode belum dipilih' }}</p>
                        <p class="mt-1 text-xs text-primary-700">{{ $payment->updated_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                @empty
                    <p class="mt-3 text-sm text-primary-700">Belum ada pembayaran.</p>
                @endforelse
            </x-ui.card>
            @if ($order->eTicket)
                <x-ui.card>
                    <h2 class="font-display text-xl font-extrabold">E-ticket Terbit</h2>
                    <p class="mt-2 break-all font-bold text-primary-700">{{ $order->eTicket->ticket_code }}</p>
                </x-ui.card>
            @endif
        </div>
    </div>
@endsection
