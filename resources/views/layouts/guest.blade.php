<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>The Nice Park Rumpin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=baloo-2:600,700,800|nunito:400,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-primary-100 via-cream to-sunny-100 font-sans text-primary-900 antialiased">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-12">
        <div class="pointer-events-none absolute -left-20 top-10 h-64 w-64 rounded-full bg-sunny-300/60 blur-sm" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -bottom-16 -right-10 h-72 w-72 rounded-full bg-primary-200/70 blur-sm" aria-hidden="true"></div>
        <div class="relative w-full max-w-lg">
            <a href="{{ route('catalog.index') }}" class="mb-6 block text-center font-display text-3xl font-extrabold text-primary-800">The Nice <span class="text-sunny-600">Park</span></a>
            <section class="rounded-3xl border-2 border-primary-100 bg-white p-6 shadow-[0_20px_60px_rgba(17,114,47,0.16)] sm:p-9">
                {{ $slot }}
            </section>
        </div>
    </main>
</body>
</html>
