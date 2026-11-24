@props([
    'title',
    'description' => null,
])

<div {{ $attributes->class(['space-y-1 text-left']) }}>
    <h2 class="font-display text-2xl font-bold tracking-normal text-ink sm:text-3xl">{{ $title }}</h2>
    @if ($description)
        <p class="max-w-prose text-base text-ink-soft leading-relaxed">{{ $description }}</p>
    @endif
</div>
