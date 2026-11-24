@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm placeholder:text-ink-soft/50 transition duration-150 focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20 disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed']) }}>
