@if (session('success'))
    <div role="status" class="mb-5 rounded-2xl border border-primary-200 bg-primary-50 px-5 py-4 font-semibold text-primary-800">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div role="alert" class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 font-semibold text-red-800">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div role="alert" class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800">
        <p class="font-bold">Mohon periksa kembali data berikut:</p>
        <ul class="mt-2 list-inside list-disc space-y-1">
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif
