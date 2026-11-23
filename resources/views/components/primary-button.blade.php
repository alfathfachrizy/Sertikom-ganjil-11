<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex min-h-11 items-center justify-center rounded-full border border-transparent bg-primary-600 px-6 py-3 font-bold text-white shadow-md transition hover:bg-primary-700 focus:outline-none focus:ring-4 focus:ring-primary-200 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
