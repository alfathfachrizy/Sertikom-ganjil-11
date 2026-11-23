<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'The Nice Park Rumpin') · The Nice Park</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=baloo-2:600,700,800|nunito:400,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-cream font-sans text-primary-900 antialiased">
    <div class="min-h-screen">
        <header class="sticky top-0 z-40 border-b border-primary-100 bg-white/95 backdrop-blur">
            <nav x-data="{ open: false }" class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-8" aria-label="Navigasi utama">
                <a href="{{ route('catalog.index') }}" class="shrink-0 font-display text-xl font-extrabold leading-tight text-primary-800 sm:text-2xl">
                    The Nice <span class="text-sunny-600">Park</span>
                </a>
                <div class="hidden items-center gap-6 text-sm font-bold md:flex">
                    <a class="hover:text-primary-600" href="{{ route('catalog.index') }}">Beranda</a>
                    <a class="hover:text-primary-600" href="{{ route('catalog.index') }}#tiket">Tiket</a>
                    <a class="hover:text-primary-600" href="{{ route('catalog.index') }}#paket-sekolah">Paket Sekolah</a>
                </div>
                <div class="hidden items-center gap-3 md:flex">
                    @guest
                        <x-ui.button variant="ghost" :href="route('login')">Masuk</x-ui.button>
                        <x-ui.button variant="secondary" :href="route('register')">Daftar</x-ui.button>
                    @else
                        @if (auth()->user()->isAdmin())
                            <x-ui.button :href="route('admin.dashboard')">Panel Admin</x-ui.button>
                        @else
                            <a class="rounded-full px-3 py-3 font-bold hover:bg-primary-50" href="{{ route('orders.index') }}">Pesanan Saya</a>
                            <a class="rounded-full px-3 py-3 font-bold hover:bg-primary-50" href="{{ route('profile.edit') }}">Profil</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-ui.button type="submit" variant="ghost">Keluar</x-ui.button>
                        </form>
                    @endguest
                </div>
                <button type="button" class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-full bg-primary-50 text-primary-800 md:hidden" @click="open = !open" :aria-expanded="open.toString()" aria-label="Buka menu">
                    <span x-show="!open" aria-hidden="true">☰</span>
                    <span x-show="open" x-cloak aria-hidden="true">✕</span>
                </button>
                <div x-show="open" x-cloak x-transition class="absolute inset-x-0 top-full border-b border-primary-100 bg-white p-4 shadow-xl md:hidden">
                    <div class="mx-auto flex max-w-7xl flex-col gap-2 font-bold">
                        <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('catalog.index') }}">Beranda</a>
                        <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('catalog.index') }}#tiket">Tiket</a>
                        <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('catalog.index') }}#paket-sekolah">Paket Sekolah</a>
                        @guest
                            <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('login') }}">Masuk</a>
                            <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('register') }}">Daftar</a>
                        @else
                            @if (auth()->user()->isAdmin())
                                <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('admin.dashboard') }}">Panel Admin</a>
                            @else
                                <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('orders.index') }}">Pesanan Saya</a>
                                <a class="rounded-xl px-4 py-3 hover:bg-primary-50" href="{{ route('profile.edit') }}">Profil</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="min-h-11 w-full rounded-xl px-4 py-3 text-left hover:bg-primary-50">Keluar</button>
                            </form>
                        @endguest
                    </div>
                </div>
            </nav>
        </header>

        <main class="min-h-[60vh]">
            <div class="mx-auto max-w-7xl px-4 pt-5 sm:px-6 lg:px-8">
                <x-ui.flash />
            </div>
            @yield('content')
        </main>

        <footer class="relative mt-20 bg-primary-900 text-white">
            <div class="absolute -top-10 left-0 w-full overflow-hidden leading-none" aria-hidden="true">
                <svg class="h-12 w-full" viewBox="0 0 1440 80" preserveAspectRatio="none">
                    <path fill="#0E4B24" d="M0,48 C180,8 360,88 540,48 C720,8 900,88 1080,48 C1260,8 1380,36 1440,24 L1440,80 L0,80 Z"></path>
                </svg>
            </div>
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 pb-10 pt-12 sm:px-6 md:grid-cols-3 lg:px-8">
                <div>
                    <p class="font-display text-2xl font-extrabold">The Nice <span class="text-sunny-400">Park</span></p>
                    <p class="mt-3 text-sm text-primary-100">Tempat seru untuk bermain, belajar, dan menikmati waktu bersama.</p>
                </div>
                <div>
                    <h2 class="font-bold text-sunny-300">Kunjungi Kami</h2>
                    <p class="mt-3 text-sm leading-6 text-primary-100">Kp Cisirung, RT.003/RW.001, Kec. Rumpin, Kabupaten Bogor, Jawa Barat 16350</p>
                </div>
                <div>
                    <h2 class="font-bold text-sunny-300">Informasi</h2>
                    <p class="mt-3 text-sm leading-6 text-primary-100">Weekday 09.00–17.45<br>Weekend 08.00–17.45<br>Instagram @theniceparkrumpin<br>Rombongan minimal 20 orang</p>
                </div>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>
