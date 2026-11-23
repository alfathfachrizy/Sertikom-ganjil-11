@props([
    'title' => 'Belum ada data',
    'message' => 'Data yang Anda cari belum tersedia.',
    'href' => null,
    'button' => null,
    'emoji' => '🌱',
])

<div {{ $attributes->class(['rounded-3xl border-2 border-dashed border-primary-200 bg-white/70 px-6 py-12 text-center']) }}>
    <div class="text-5xl" aria-hidden="true">{{ $emoji }}</div>
    <h3 class="mt-4 font-display text-2xl font-extrabold text-primary-900">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-lg text-primary-800/75">{{ $message }}</p>
    @if ($href && $button)
        <x-ui.button :href="$href" class="mt-6">{{ $button }}</x-ui.button>
    @endif
</div>
