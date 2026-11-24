@extends('layouts.public')

@section('title', 'Pesanan Saya')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <x-ui.page-header
            title="Riwayat Pesanan Saya"
            subtitle="Daftar pemesanan tiket masuk dan pengajuan kunjungan rombongan sekolah Anda."
        />

        @if ($orders->isNotEmpty())
            {{-- Tampilan Desktop: Tabel Baris Bersih --}}
            <div class="mt-8 hidden overflow-hidden rounded-2xl border border-line bg-white shadow-sm md:block">
                <table class="min-w-full divide-y divide-line text-left text-sm">
                    <thead class="bg-primary-50/50 text-xs font-bold uppercase tracking-wider text-ink-soft">
                        <tr>
                            <th scope="col" class="px-6 py-4">Kode Pesanan</th>
                            <th scope="col" class="px-6 py-4">Jenis & Keterangan</th>
                            <th scope="col" class="px-6 py-4">Tanggal Kunjungan</th>
                            <th scope="col" class="px-6 py-4 text-right">Total Biaya</th>
                            <th scope="col" class="px-6 py-4 text-center">Status</th>
                            <th scope="col" class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-line">
                        @foreach ($orders as $order)
                            <tr class="transition hover:bg-cream/40">
                                <td class="whitespace-nowrap px-6 py-4 font-bold text-ink">
                                    {{ $order->order_code }}
                                </td>
                                <td class="px-6 py-4 text-ink-soft">
                                    <div class="font-semibold text-ink">
                                        {{ $order->order_type === 'school' ? 'Paket Rombongan Sekolah' : 'Tiket Reguler' }}
                                    </div>
                                    @if ($order->schoolSubmission)
                                        <div class="text-xs text-ink-soft truncate max-w-xs">
                                            {{ $order->schoolSubmission->school_name }}
                                        </div>
                                    @endif
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
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <x-ui.button variant="ghost" size="sm" :href="route('orders.show', $order)">
                                        <span>Rincian</span>
                                        <x-ui.icon name="arrow-right" class="size-4" />
                                    </x-ui.button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tampilan Mobile: Kartu Ringkas --}}
            <div class="mt-6 space-y-4 md:hidden">
                @foreach ($orders as $order)
                    <div class="rounded-2xl border border-line bg-white p-5 shadow-sm space-y-3">
                        <div class="flex items-center justify-between border-b border-line pb-3">
                            <span class="font-bold text-ink">{{ $order->order_code }}</span>
                            <x-ui.status-badge :status="$order->status" />
                        </div>
                        <div class="text-sm text-ink-soft space-y-1">
                            <p class="font-semibold text-ink">{{ $order->order_type === 'school' ? 'Paket Rombongan Sekolah' : 'Tiket Reguler' }}</p>
                            @if ($order->schoolSubmission)
                                <p class="text-xs text-ink-soft">{{ $order->schoolSubmission->school_name }}</p>
                            @endif
                            <p class="text-xs">Kunjungan: {{ $order->visit_date->translatedFormat('d F Y') }}</p>
                        </div>
                        <div class="flex items-center justify-between border-t border-line pt-3">
                            <span class="font-display text-lg font-bold text-primary-700">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                            <x-ui.button size="sm" :href="route('orders.show', $order)">Rincian</x-ui.button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <div class="mt-8">
                <x-ui.empty-state
                    title="Belum ada riwayat pesanan"
                    message="Anda belum melakukan pemesanan tiket atau pengajuan paket. Mulai jelajahi katalog kami."
                    :href="route('catalog.index')"
                    button="Pilih Tiket Sekarang"
                    icon="ticket"
                />
            </div>
        @endif
    </div>
@endsection
