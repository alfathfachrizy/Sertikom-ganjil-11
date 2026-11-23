@props(['variant' => 'primary', 'type' => 'button', 'href' => null])

@php
    $classes = match ($variant) {
        'secondary' => 'bg-sunny-400 text-primary-900 hover:bg-sunny-300',
        'danger' => 'bg-red-500 text-white hover:bg-red-600',
        'ghost' => 'bg-transparent text-primary-700 hover:bg-primary-50',
        default => 'bg-primary-600 text-white hover:bg-primary-700',
    };
    $baseClasses = 'inline-flex min-h-11 items-center justify-center gap-2 rounded-full px-6 py-3 text-center font-bold shadow-md transition focus:outline-none focus:ring-4 focus:ring-primary-200';
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class([$baseClasses, $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$baseClasses, $classes]) }}>{{ $slot }}</button>
@endif
