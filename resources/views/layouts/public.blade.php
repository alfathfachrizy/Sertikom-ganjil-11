<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Nice Park Rumpin') · The Nice Park</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=baloo-2:600,700|nunito:400,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-ink antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-40 border-b border-line bg-white/95 backdrop-blur">
            <nav x-data="{ open: false }" class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8" aria-label="Navigasi utama">
                <a href="{{ route('catalog.index') }}" class="shrink-0 font-display text-2xl font-bold tracking-tight text-primary-900">
                    The Nice <span class="text-primary-600">Park</span>
                </a>

                <div class="hidden items-center gap-6 text-sm font-semibold md:flex">
                    <a class="relative py-1 text-ink-soft transition hover:text-primary-700 {{ request()->routeIs('catalog.index') && !request()->has('section') ? 'text-primary-700 after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-full after:bg-primary-600' : '' }}" href="{{ route('catalog.index') }}">Beranda</a>
                    <a class="relative py-1 text-ink-soft transition hover:text-primary-700" href="{{ route('catalog.index') }}#tiket">Tiket</a>
                    <a class="relative py-1 text-ink-soft transition hover:text-primary-700" href="{{ route('catalog.index') }}#paket-sekolah">Paket Sekolah</a>
                </div>

                <div class="hidden items-center gap-3 md:flex">
                    @guest
                        <x-ui.button variant="ghost" size="sm" :href="route('login')">Masuk</x-ui.button>
                        <x-ui.button variant="secondary" size="sm" :href="route('register')">Daftar</x-ui.button>
                    @else
                        @if (auth()->user()->isAdmin())
                            <x-ui.button size="sm" :href="route('admin.dashboard')">Panel Admin</x-ui.button>
                        @else
                            <a class="rounded-full px-3 py-2 text-sm font-semibold text-ink hover:bg-primary-50 hover:text-primary-700" href="{{ route('orders.index') }}">Pesanan Saya</a>
                            <a class="rounded-full px-3 py-2 text-sm font-semibold text-ink hover:bg-primary-50 hover:text-primary-700" href="{{ route('profile.edit') }}">Profil</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.button type="submit" variant="ghost" size="sm">Keluar</x-ui.button>
                        </form>
                    @endguest
                </div>

                <button type="button" class="inline-flex size-11 items-center justify-center rounded-full border border-line bg-white text-ink transition hover:bg-primary-50 md:hidden" @click="open = !open" :aria-expanded="open.toString()" aria-label="Buka menu">
                    <x-ui.icon name="menu" class="size-5" x-show="!open" />
                    <x-ui.icon name="close" class="size-5" x-show="open" x-cloak />
                </button>

                <div x-show="open" x-cloak x-transition class="absolute inset-x-0 top-full border-b border-line bg-white p-4 shadow-md md:hidden">
                    <div class="mx-auto flex max-w-6xl flex-col gap-1 text-sm font-semibold">
                        <a class="rounded-xl px-4 py-2.5 text-ink hover:bg-primary-50" href="{{ route('catalog.index') }}">Beranda</a>
                        <a class="rounded-xl px-4 py-2.5 text-ink hover:bg-primary-50" href="{{ route('catalog.index') }}#tiket">Tiket</a>
                        <a class="rounded-xl px-4 py-2.5 text-ink hover:bg-primary-50" href="{{ route('catalog.index') }}#paket-sekolah">Paket Sekolah</a>
                        <hr class="my-2 border-line">
                        @guest
                            <a class="rounded-xl px-4 py-2.5 text-ink hover:bg-primary-50" href="{{ route('login') }}">Masuk</a>
                            <a class="rounded-xl px-4 py-2.5 text-primary-700 font-bold hover:bg-primary-50" href="{{ route('register') }}">Daftar</a>
                        @else
                            @if (auth()->user()->isAdmin())
                                <a class="rounded-xl px-4 py-2.5 text-primary-700 font-bold hover:bg-primary-50" href="{{ route('admin.dashboard') }}">Panel Admin</a>
                            @else
                                <a class="rounded-xl px-4 py-2.5 text-ink hover:bg-primary-50" href="{{ route('orders.index') }}">Pesanan Saya</a>
                                <a class="rounded-xl px-4 py-2.5 text-ink hover:bg-primary-50" href="{{ route('profile.edit') }}">Profil</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left rounded-xl px-4 py-2.5 text-red-600 hover:bg-red-50">Keluar</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </nav>
        </header>

        <main class="flex-1">
            <div class="mx-auto max-w-6xl px-4 pt-6 sm:px-6 lg:px-8">
                <x-ui.flash />
            </div>
            @yield('content')
        </main>

        <footer class="mt-20 border-t border-primary-950 bg-primary-900 text-cream">
            <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 px-4 py-12 sm:px-6 md:grid-cols-3 lg:px-8">
                <div class="space-y-3">
                    <p class="font-display text-2xl font-bold text-white">The Nice <span class="text-sunny-400">Park</span></p>
                    <p class="text-sm leading-relaxed text-cream/80 max-w-sm">Tempat rekreasi keluarga di Rumpin Bogor dengan wahana seru, mini zoo edukatif, dan area bermain anak.</p>
                </div>
                <div class="space-y-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-sunny-400">Jam Operasional</h3>
                    <div class="space-y-1.5 text-sm leading-relaxed text-cream/80">
                        <p class="flex items-center gap-2">
                            <x-ui.icon name="clock" class="size-4 shrink-0 text-sunny-400" />
                            <span>Weekday: 09.00 – 17.45 WIB</span>
                        </p>
                        <p class="flex items-center gap-2">
                            <x-ui.icon name="clock" class="size-4 shrink-0 text-sunny-400" />
                            <span>Weekend: 08.00 – 17.45 WIB</span>
                        </p>
                        <p class="text-xs text-cream/60 pt-1">Rombongan minimal 20 orang</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <h3 class="text-sm font-bold uppercase tracking-wider text-sunny-400">Lokasi & Kontak</h3>
                    <div class="space-y-2 text-sm leading-relaxed text-cream/80">
                        <p class="flex items-start gap-2">
                            <x-ui.icon name="map-pin" class="size-4 shrink-0 text-sunny-400 mt-1" />
                            <span>Kp Cisirung, RT.003/RW.001, Kec. Rumpin, Kabupaten Bogor, Jawa Barat 16350</span>
                        </p>
                        <p class="text-xs text-cream/60">Instagram: @theniceparkrumpin</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10 py-4 text-center text-xs text-cream/60">
                &copy; {{ date('Y') }} The Nice Park Rumpin. Seluruh hak cipta dilindungi.
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
