@props(['name', 'label', 'hint' => null])

<div {{ $attributes->class(['space-y-1.5']) }}>
    <label for="{{ $name }}" class="block text-sm font-bold text-ink">{{ $label }}</label>
    {{ $slot }}
    @if ($hint)
        <p class="text-sm text-ink-soft leading-relaxed">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="flex items-center gap-1.5 text-sm font-semibold text-red-600">
            <x-ui.icon name="x-circle" class="size-4 shrink-0 text-red-500" />
            <span>{{ $message }}</span>
        </p>
    @enderror
</div>
