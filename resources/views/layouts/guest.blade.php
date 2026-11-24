<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'The Nice Park Rumpin') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=baloo-2:600,700|nunito:400,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-ink antialiased">
    <main class="flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="{{ route('catalog.index') }}" class="font-display text-3xl font-bold tracking-tight text-primary-900">
                    The Nice <span class="text-primary-600">Park</span>
                </a>
            </div>

            <section class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                {{ $slot }}
            </section>
        </div>
    </main>
</body>
</html>
