@if (session('success'))
    <div role="status" class="mb-6 flex items-start gap-3 rounded-xl border border-primary-100 bg-primary-50 p-4 text-sm font-semibold text-primary-900">
        <x-ui.icon name="check-circle" class="size-5 shrink-0 text-primary-600 mt-0.5" />
        <div class="flex-1">{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div role="alert" class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-900">
        <x-ui.icon name="alert-triangle" class="size-5 shrink-0 text-red-600 mt-0.5" />
        <div class="flex-1">{{ session('error') }}</div>
    </div>
@endif

@if ($errors->any())
    <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">
        <div class="flex items-center gap-2 font-bold text-red-800">
            <x-ui.icon name="alert-triangle" class="size-5 text-red-600" />
            <span>Mohon periksa kembali formulir Anda:</span>
        </div>
        <ul class="mt-2 list-inside list-disc space-y-1 pl-1">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
