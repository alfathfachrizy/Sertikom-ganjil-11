@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-bold text-primary-900']) }}>
    {{ $value ?? $slot }}
</label>
