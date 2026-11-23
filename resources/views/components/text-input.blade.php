@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block min-h-11 w-full rounded-xl border-2 border-primary-100 bg-white px-4 py-3 text-primary-900 shadow-sm placeholder:text-primary-800/45 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 disabled:bg-gray-100']) }}>
