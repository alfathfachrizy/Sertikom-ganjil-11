<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') · The Nice Park</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=baloo-2:600,700,800|nunito:400,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-primary-900 antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">
        <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 z-40 bg-primary-900/60 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-primary-900 text-white transition-transform duration-200 lg:static lg:z-auto lg:min-h-screen lg:translate-x-0">
            <a href="{{ route('admin.dashboard') }}" class="border-b border-white/10 px-6 py-6 font-display text-2xl font-extrabold">The Nice <span class="text-sunny-400">Park</span></a>
            <nav class="flex flex-1 flex-col gap-2 px-4 py-6" aria-label="Menu admin">
                <a href="{{ route('admin.dashboard') }}" @class(['rounded-2xl px-4 py-3 font-bold transition hover:bg-white/10', 'bg-white/15 text-sunny-300' => request()->routeIs('admin.dashboard')])>📊 Dashboard</a>
                <a href="{{ route('admin.tickets.index') }}" @class(['rounded-2xl px-4 py-3 font-bold transition hover:bg-white/10', 'bg-white/15 text-sunny-300' => request()->routeIs('admin.tickets.*')])>🎟️ Tiket</a>
                <a href="{{ route('admin.school-packages.index') }}" @class(['rounded-2xl px-4 py-3 font-bold transition hover:bg-white/10', 'bg-white/15 text-sunny-300' => request()->routeIs('admin.school-packages.*')])>🎒 Paket Sekolah</a>
                <a href="{{ route('admin.school-submissions.index') }}" @class(['rounded-2xl px-4 py-3 font-bold transition hover:bg-white/10', 'bg-white/15 text-sunny-300' => request()->routeIs('admin.school-submissions.*')])>📝 Pengajuan Sekolah</a>
                <a href="{{ route('admin.orders.index') }}" @class(['rounded-2xl px-4 py-3 font-bold transition hover:bg-white/10', 'bg-white/15 text-sunny-300' => request()->routeIs('admin.orders.*')])>🧾 Pesanan</a>
                <div class="mt-auto flex flex-col gap-2 border-t border-white/10 pt-5">
                    <a href="{{ route('catalog.index') }}" class="rounded-2xl px-4 py-3 font-bold hover:bg-white/10">↗ Lihat Website</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="min-h-11 w-full rounded-2xl px-4 py-3 text-left font-bold hover:bg-white/10">Keluar</button>
                    </form>
                </div>
            </nav>
        </aside>
        <div class="min-w-0 flex-1">
            <header class="sticky top-0 z-30 flex min-h-16 items-center justify-between gap-4 border-b border-primary-100 bg-white/90 px-4 backdrop-blur sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button type="button" class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-full bg-primary-50 text-xl text-primary-800 lg:hidden" @click="sidebarOpen = true" aria-label="Buka menu admin">☰</button>
                    <span class="font-display text-xl font-extrabold text-primary-900">Panel Pengelola</span>
                </div>
                <span class="hidden rounded-full bg-sunny-100 px-4 py-2 text-sm font-bold text-primary-900 sm:inline-flex">{{ auth()->user()->name }}</span>
            </header>
            <main class="mx-auto max-w-7xl px-4 py-7 sm:px-6 lg:px-8 lg:py-10">
                <x-ui.flash />
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
