@extends('layouts.public')

@section('title', 'Pembayaran Pesanan')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <x-ui.page-header
            title="Selesaikan Pembayaran"
            subtitle="Pembayaran diproses secara aman melalui payment gateway Midtrans."
        />

        {{-- Layout dua kolom: ringkasan di kiri, panel aksi pembayaran di kanan --}}
        <div class="mt-8 grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            {{-- Ringkasan Pesanan di Kiri --}}
            <div class="lg:col-span-7">
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <div class="flex items-center justify-between border-b border-line pb-4">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Kode Transaksi</span>
                            <p class="font-display text-xl font-bold text-ink">{{ $order->order_code }}</p>
                        </div>
                        <x-ui.status-badge :status="$order->status" />
                    </div>

                    <div class="mt-6 space-y-3 text-sm">
                        <div class="flex justify-between text-ink-soft">
                            <span>Jenis Pesanan</span>
                            <span class="font-semibold text-ink">{{ $order->order_type === 'school' ? 'Paket Rombongan Sekolah' : 'Tiket Masuk Reguler' }}</span>
                        </div>
                        <div class="flex justify-between text-ink-soft">
                            <span>Tanggal Kunjungan</span>
                            <span class="font-semibold text-ink">{{ $order->visit_date->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex justify-between text-ink-soft">
                            <span>Nama Pemesan</span>
                            <span class="font-semibold text-ink">{{ $order->user->name }}</span>
                        </div>
                        <div class="flex justify-between text-ink-soft">
                            <span>Email Pemesan</span>
                            <span class="font-semibold text-ink">{{ $order->user->email }}</span>
                        </div>
                    </div>

                    <div class="mt-6 rounded-xl border border-line bg-cream p-4">
                        <div class="flex items-baseline justify-between">
                            <span class="font-bold text-ink">Total Tagihan</span>
                            <span class="font-display text-2xl font-bold text-primary-700">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel Aksi di Kanan --}}
            <div class="lg:col-span-5">
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <h3 class="font-display text-lg font-bold text-ink">Instruksi Pembayaran</h3>
                    <p class="mt-2 text-sm text-ink-soft leading-relaxed">
                        Klik tombol di bawah untuk membuka jendela pembayaran Midtrans. Anda dapat memilih metode QRIS, transfer bank (VA), atau e-wallet.
                    </p>

                    <div id="snap-checkout" class="mt-6" data-token="{{ $payment->snap_token }}" data-finish-url="{{ route('payments.finish', $order) }}">
                        <button
                            id="snap-pay-button"
                            type="button"
                            class="inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-full bg-primary-600 px-6 py-3 text-base font-bold text-white shadow-sm transition duration-150 ease-in-out hover:bg-primary-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2"
                        >
                            <x-ui.icon name="credit-card" class="size-5" />
                            <span>Bayar Sekarang</span>
                        </button>
                        <p id="snap-message" role="status" class="mt-3 text-center text-sm font-semibold text-red-600"></p>
                    </div>

                    <div class="mt-6">
                        <x-ui.info-box variant="sunny">
                            Mode sandbox (uji coba pembayaran). Tidak ada pemotongan saldo uang sungguhan.
                        </x-ui.info-box>
                    </div>
                </div>
            </div>
        </div>
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
