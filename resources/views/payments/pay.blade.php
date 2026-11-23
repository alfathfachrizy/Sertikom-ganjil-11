@extends('layouts.public')

@section('title', 'Pembayaran')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10 sm:px-6 lg:px-8">
        <x-ui.page-header title="Selesaikan Pembayaran" subtitle="Pembayaran aman diproses melalui Midtrans." />
        <x-ui.card class="mt-8">
            <div class="flex items-start gap-4">
                <span class="text-4xl">🧾</span>
                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-primary-600">Kode pesanan</p>
                    <p class="break-all font-display text-xl font-extrabold">{{ $order->order_code }}</p>
                    <p class="mt-1 text-sm text-primary-700">Tanggal kunjungan {{ $order->visit_date->translatedFormat('d F Y') }}</p>
                </div>
                <x-ui.status-badge :status="$order->status" />
            </div>
            <div class="mt-6 flex items-center justify-between border-t border-primary-100 pt-5">
                <span class="font-bold">Total pembayaran</span>
                <span class="font-display text-3xl font-extrabold text-primary-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div id="snap-checkout" class="mt-7" data-token="{{ $payment->snap_token }}" data-finish-url="{{ route('payments.finish', $order) }}">
                <button id="snap-pay-button" type="button" class="inline-flex min-h-12 w-full items-center justify-center rounded-full bg-primary-600 px-6 py-3 font-bold text-white shadow-md transition hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-200">Bayar Sekarang</button>
                <p id="snap-message" role="status" class="mt-3 text-center text-sm font-semibold text-primary-700"></p>
            </div>
            <p class="mt-5 rounded-2xl bg-sunny-50 px-4 py-3 text-center text-sm text-primary-800">Mode uji coba (Sandbox), tidak ada uang sungguhan.</p>
        </x-ui.card>
    </div>
@endsection

@push('scripts')
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const checkout = document.getElementById('snap-checkout');
            const button = document.getElementById('snap-pay-button');
            const message = document.getElementById('snap-message');

            button.addEventListener('click', () => {
                message.textContent = '';
                window.snap.pay(checkout.dataset.token, {
                    onSuccess: () => { window.location.href = checkout.dataset.finishUrl; },
                    onPending: () => { window.location.href = checkout.dataset.finishUrl; },
                    onError: () => { message.textContent = 'Pembayaran gagal diproses. Silakan coba kembali.'; },
                    onClose: () => { message.textContent = 'Pembayaran belum diselesaikan.'; },
                });
            });
        });
    </script>
@endpush
