@props([
    'variant' => 'primary', // primary | secondary | ghost | danger
    'size' => 'md', // md | sm
    'type' => 'button',
    'href' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 rounded-full font-bold transition duration-150 ease-in-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed select-none';

    $sizeClasses = match ($size) {
        'sm' => 'min-h-[40px] px-4 py-2 text-sm',
        default => 'min-h-[44px] px-6 py-2.5 text-base',
    };

    $variantClasses = match ($variant) {
        'secondary' => 'bg-sunny-400 text-ink hover:bg-sunny-300 shadow-sm',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm',
        'ghost' => 'bg-transparent text-primary-700 hover:bg-primary-50 hover:text-primary-900',
        default => 'bg-primary-600 text-white hover:bg-primary-700 shadow-sm',
    };

    $allClasses = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $allClasses]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $allClasses]) }}>{{ $slot }}</button>
@endif
