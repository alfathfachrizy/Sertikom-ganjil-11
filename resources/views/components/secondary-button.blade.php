<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex min-h-[44px] items-center justify-center gap-2 rounded-full bg-sunny-400 px-6 py-2.5 text-base font-bold text-ink shadow-sm transition duration-150 ease-in-out hover:bg-sunny-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary-600 focus-visible:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed select-none']) }}>
    {{ $slot }}
</button>
