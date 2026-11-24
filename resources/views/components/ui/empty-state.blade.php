@props([
    'title' => 'Belum ada data',
    'message' => 'Data yang Anda cari belum tersedia.',
    'href' => null,
    'button' => null,
    'icon' => 'ticket',
])

<div {{ $attributes->class(['rounded-2xl border border-dashed border-line bg-white/70 px-6 py-12 text-center']) }}>
    <div class="mx-auto flex size-12 items-center justify-center rounded-full bg-primary-50 text-primary-700" aria-hidden="true">
        <x-ui.icon :name="$icon" class="size-6" />
    </div>
    <h3 class="mt-4 font-display text-xl font-bold text-ink sm:text-2xl">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-prose text-sm text-ink-soft leading-relaxed">{{ $message }}</p>
    @if ($href && $button)
        <div class="mt-6">
            <x-ui.button :href="$href" size="sm">{{ $button }}</x-ui.button>
        </div>
    @endif
</div>
