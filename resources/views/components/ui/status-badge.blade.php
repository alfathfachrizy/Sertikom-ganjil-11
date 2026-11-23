@props(['status'])

@php
    $labels = [
        'pending_approval' => 'Menunggu Persetujuan',
        'pending' => 'Menunggu Persetujuan',
        'rejected' => 'Ditolak',
        'approved' => 'Disetujui',
        'awaiting_payment' => 'Menunggu Pembayaran',
        'paid' => 'Lunas',
        'cancelled' => 'Dibatalkan',
        'expired' => 'Kedaluwarsa',
    ];
    $colors = [
        'pending_approval' => 'bg-sunny-100 text-primary-900',
        'pending' => 'bg-sunny-100 text-primary-900',
        'rejected' => 'bg-red-100 text-red-800',
        'approved' => 'bg-primary-100 text-primary-800',
        'awaiting_payment' => 'bg-orange-500 text-white',
        'paid' => 'bg-primary-600 text-white',
        'cancelled' => 'bg-gray-100 text-gray-700',
        'expired' => 'bg-gray-100 text-gray-700',
    ];
@endphp

<span {{ $attributes->class(['inline-flex min-h-8 items-center rounded-full px-3 py-1 text-xs font-extrabold', $colors[$status] ?? 'bg-gray-100 text-gray-700']) }}>
    {{ $labels[$status] ?? str($status)->replace('_', ' ')->title() }}
</span>
