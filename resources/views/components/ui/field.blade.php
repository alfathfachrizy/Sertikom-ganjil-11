@props(['name', 'label', 'hint' => null])

<div {{ $attributes->class(['space-y-2']) }}>
    <label for="{{ $name }}" class="block font-bold text-primary-900">{{ $label }}</label>
    {{ $slot }}
    @if ($hint)
        <p class="text-sm text-primary-800/70">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="text-sm font-semibold text-red-700">{{ $message }}</p>
    @enderror
</div>
