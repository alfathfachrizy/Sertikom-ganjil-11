@props(['status'])

@php
    $labels = [
        'pending_approval' => 'Menunggu persetujuan',
        'pending' => 'Menunggu persetujuan',
        'awaiting_payment' => 'Menunggu pembayaran',
        'approved' => 'Disetujui',
        'paid' => 'Lunas',
        'rejected' => 'Ditolak',
        'cancelled' => 'Dibatalkan',
        'expired' => 'Kedaluwarsa',
    ];

    // Proporsi & panduan warna:
    // Menunggu Persetujuan = kuning (sunny-100)
    // Menunggu Pembayaran = oranye lembut (orange-50)
    // Lunas / Disetujui = hijau (primary-100)
    // Ditolak = merah lembut (red-50)
    // Dibatalkan / Kedaluwarsa = abu (gray-100)
    $colors = [
        'pending_approval' => 'bg-sunny-100 text-ink border border-line',
        'pending' => 'bg-sunny-100 text-ink border border-line',
        'awaiting_payment' => 'bg-orange-50 text-orange-900 border border-orange-200',
        'approved' => 'bg-primary-100 text-primary-900 border border-primary-200',
        'paid' => 'bg-primary-100 text-primary-900 border border-primary-200',
        'rejected' => 'bg-red-50 text-red-800 border border-red-200',
        'cancelled' => 'bg-gray-100 text-gray-700 border border-gray-200',
        'expired' => 'bg-gray-100 text-gray-700 border border-gray-200',
    ];
@endphp

<span {{ $attributes->class(['inline-flex min-h-7 items-center rounded-full px-3 py-0.5 text-xs font-semibold', $colors[$status] ?? 'bg-gray-100 text-gray-700 border border-gray-200']) }}>
    {{ $labels[$status] ?? str($status)->replace('_', ' ')->lower() }}
</span>
