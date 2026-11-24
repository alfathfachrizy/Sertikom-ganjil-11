<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Panel Admin') · The Nice Park</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=baloo-2:600,700|nunito:400,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-ink antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen lg:flex">
        {{-- Mobile Overlay Backdrop --}}
        <div
            x-show="sidebarOpen"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-40 bg-ink/60 backdrop-blur-xs lg:hidden"
            @click="sidebarOpen = false"
            aria-hidden="true"
        ></div>

        {{-- Sidebar Admin (primary-900, ikon SVG seragam, item aktif primary-700) --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col bg-primary-900 text-cream transition-transform duration-200 lg:static lg:z-auto lg:min-h-screen lg:translate-x-0"
        >
            <div class="flex h-16 items-center justify-between border-b border-white/10 px-6">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-xl font-bold tracking-tight text-white">
                    The Nice <span class="text-sunny-400">Park</span>
                </a>
                <button type="button" class="text-cream/70 hover:text-white lg:hidden" @click="sidebarOpen = false" aria-label="Tutup menu">
                    <x-ui.icon name="close" class="size-5" />
                </button>
            </div>

            <nav class="flex flex-1 flex-col gap-1 p-4 text-sm font-semibold" aria-label="Menu navigasi admin">
                <a
                    href="{{ route('admin.dashboard') }}"
                    @class([
                        'flex items-center gap-3 rounded-xl px-4 py-2.5 transition duration-150',
                        'bg-primary-700 text-white font-bold' => request()->routeIs('admin.dashboard'),
                        'text-cream/80 hover:bg-white/10 hover:text-white' => !request()->routeIs('admin.dashboard'),
                    ])
                >
                    <x-ui.icon name="chart" class="size-5 shrink-0" />
                    <span>Dashboard</span>
                </a>

                <a
                    href="{{ route('admin.tickets.index') }}"
                    @class([
                        'flex items-center gap-3 rounded-xl px-4 py-2.5 transition duration-150',
                        'bg-primary-700 text-white font-bold' => request()->routeIs('admin.tickets.*'),
                        'text-cream/80 hover:bg-white/10 hover:text-white' => !request()->routeIs('admin.tickets.*'),
                    ])
                >
                    <x-ui.icon name="ticket" class="size-5 shrink-0" />
                    <span>Tiket Masuk</span>
                </a>

                <a
                    href="{{ route('admin.school-packages.index') }}"
                    @class([
                        'flex items-center gap-3 rounded-xl px-4 py-2.5 transition duration-150',
                        'bg-primary-700 text-white font-bold' => request()->routeIs('admin.school-packages.*'),
                        'text-cream/80 hover:bg-white/10 hover:text-white' => !request()->routeIs('admin.school-packages.*'),
                    ])
                >
                    <x-ui.icon name="school" class="size-5 shrink-0" />
                    <span>Paket Sekolah</span>
                </a>

                <a
                    href="{{ route('admin.school-submissions.index') }}"
                    @class([
                        'flex items-center gap-3 rounded-xl px-4 py-2.5 transition duration-150',
                        'bg-primary-700 text-white font-bold' => request()->routeIs('admin.school-submissions.*'),
                        'text-cream/80 hover:bg-white/10 hover:text-white' => !request()->routeIs('admin.school-submissions.*'),
                    ])
                >
                    <x-ui.icon name="users" class="size-5 shrink-0" />
                    <span>Pengajuan Sekolah</span>
                </a>

                <a
                    href="{{ route('admin.orders.index') }}"
                    @class([
                        'flex items-center gap-3 rounded-xl px-4 py-2.5 transition duration-150',
                        'bg-primary-700 text-white font-bold' => request()->routeIs('admin.orders.*'),
                        'text-cream/80 hover:bg-white/10 hover:text-white' => !request()->routeIs('admin.orders.*'),
                    ])
                >
                    <x-ui.icon name="receipt" class="size-5 shrink-0" />
                    <span>Pesanan & Transaksi</span>
                </a>

                <div class="mt-auto border-t border-white/10 pt-4 space-y-1">
                    <a
                        href="{{ route('catalog.index') }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 text-cream/80 transition hover:bg-white/10 hover:text-white"
                    >
                        <x-ui.icon name="home" class="size-5 shrink-0" />
                        <span>Kunjungi Situs</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="flex w-full items-center gap-3 rounded-xl px-4 py-2.5 text-left text-red-300 transition hover:bg-white/10 hover:text-red-200"
                        >
                            <x-ui.icon name="close" class="size-5 shrink-0" />
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Konten Utama --}}
        <div class="flex min-w-0 flex-1 flex-col">
            {{-- Topbar Tipis --}}
            <header class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-line bg-white/95 px-4 backdrop-blur sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        class="inline-flex size-10 items-center justify-center rounded-xl border border-line bg-white text-ink transition hover:bg-primary-50 lg:hidden"
                        @click="sidebarOpen = true"
                        aria-label="Buka menu navigasi admin"
                    >
                        <x-ui.icon name="menu" class="size-5" />
                    </button>
                    <span class="font-display text-lg font-bold text-ink">Panel Pengelola</span>
                </div>

                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-line bg-cream px-3 py-1 text-xs font-semibold text-ink">
                        <x-ui.icon name="user" class="size-3.5 text-primary-600" />
                        <span>{{ auth()->user()->name }}</span>
                    </span>
                </div>
            </header>

            <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8 sm:px-6 lg:px-8">
                <x-ui.flash />
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
