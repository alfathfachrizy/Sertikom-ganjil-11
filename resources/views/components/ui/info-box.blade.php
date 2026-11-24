@props([
    'variant' => 'sunny', // sunny | primary | danger
    'icon' => null,
])

@php
    $variantClasses = match ($variant) {
        'primary' => 'bg-primary-50 border-primary-100 text-ink',
        'danger' => 'bg-red-50 border-red-200 text-red-900',
        default => 'bg-sunny-100 border-line text-ink',
    };

    $iconName = $icon ?? match ($variant) {
        'primary' => 'check-circle',
        'danger' => 'alert-triangle',
        default => 'info',
    };

    $iconClasses = match ($variant) {
        'primary' => 'text-primary-700',
        'danger' => 'text-red-600',
        default => 'text-primary-900',
    };
@endphp

<div {{ $attributes->class(['flex items-start gap-3 rounded-xl border p-4 text-sm leading-relaxed', $variantClasses]) }}>
    <x-ui.icon :name="$iconName" class="mt-0.5 size-5 shrink-0 {{ $iconClasses }}" />
    <div class="min-w-0 flex-1">
        {{ $slot }}
    </div>
</div>
