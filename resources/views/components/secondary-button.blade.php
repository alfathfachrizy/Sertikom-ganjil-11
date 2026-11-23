<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex min-h-11 items-center justify-center rounded-full border border-sunny-300 bg-sunny-400 px-6 py-3 font-bold text-primary-900 shadow-sm transition hover:bg-sunny-300 focus:outline-none focus:ring-4 focus:ring-sunny-100 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
