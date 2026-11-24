@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'space-y-1 text-sm font-semibold text-red-600']) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-center gap-1.5">
                <x-ui.icon name="x-circle" class="size-4 shrink-0 text-red-500" />
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
