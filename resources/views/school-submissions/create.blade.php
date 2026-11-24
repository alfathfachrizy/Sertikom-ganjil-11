@extends('layouts.public')

@section('title', 'Ajukan Paket Sekolah')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-8">
        <x-ui.page-header
            title="Pengajuan Paket Kunjungan Sekolah"
            subtitle="Isi data rombongan sekolah Anda untuk verifikasi tanggal kunjungan."
        />

        <div x-data="{ participants: {{ (int) old('participant_count', $package->min_participants) }}, price: {{ (float) $package->price_per_participant }} }" class="mt-8 grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
            {{-- Kolom Kiri: Form Pengajuan --}}
            <div class="lg:col-span-7">
                <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                    <form method="POST" action="{{ route('school-submissions.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="school_package_id" value="{{ $package->id }}">

                        <div class="rounded-xl border border-line bg-primary-50 p-4">
                            <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Paket yang Dipilih</span>
                            <p class="font-display text-xl font-bold text-ink">{{ $package->name }}</p>
                            <p class="mt-1 text-sm font-semibold text-primary-700">Rp {{ number_format($package->price_per_participant, 0, ',', '.') }} <span class="font-normal text-ink-soft">/ peserta (Min. {{ $package->min_participants }} peserta)</span></p>
                        </div>

                        {{-- Kelompok 1: Data Lembaga / Sekolah --}}
                        <div class="space-y-4">
                            <h3 class="border-b border-line pb-2 text-sm font-bold uppercase tracking-wider text-ink-soft">Data Lembaga</h3>
                            <x-ui.field name="school_name" label="Nama Sekolah / Institusi">
                                <input
                                    id="school_name"
                                    name="school_name"
                                    type="text"
                                    value="{{ old('school_name') }}"
                                    required
                                    maxlength="255"
                                    placeholder="Contoh: SD Negeri 01 Rumpin"
                                    class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
                                >
                            </x-ui.field>
                        </div>

                        {{-- Kelompok 2: Data Penanggung Jawab --}}
                        <div class="space-y-4 pt-2">
                            <h3 class="border-b border-line pb-2 text-sm font-bold uppercase tracking-wider text-ink-soft">Penanggung Jawab (PIC)</h3>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-ui.field name="pic_name" label="Nama Lengkap PIC">
                                    <input
                                        id="pic_name"
                                        name="pic_name"
                                        type="text"
                                        value="{{ old('pic_name') }}"
                                        required
                                        maxlength="255"
                                        placeholder="Nama guru/koordinator"
                                        class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
                                    >
                                </x-ui.field>
                                <x-ui.field name="pic_phone" label="Nomor WhatsApp / HP">
                                    <input
                                        id="pic_phone"
                                        name="pic_phone"
                                        type="tel"
                                        value="{{ old('pic_phone') }}"
                                        required
                                        maxlength="20"
                                        autocomplete="tel"
                                        placeholder="08xxxxxxxxxx"
                                        class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
                                    >
                                </x-ui.field>
                            </div>
                        </div>

                        {{-- Kelompok 3: Rencana Kunjungan --}}
                        <div class="space-y-4 pt-2">
                            <h3 class="border-b border-line pb-2 text-sm font-bold uppercase tracking-wider text-ink-soft">Rencana Kunjungan</h3>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <x-ui.field name="participant_count" label="Estimasi Jumlah Peserta" :hint="'Minimal '.$package->min_participants.' peserta.'">
                                    <input
                                        id="participant_count"
                                        name="participant_count"
                                        type="number"
                                        min="1"
                                        x-model.number="participants"
                                        value="{{ old('participant_count', $package->min_participants) }}"
                                        required
                                        class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
                                    >
                                </x-ui.field>
                                <x-ui.field name="visit_date" label="Tanggal Kunjungan">
                                    <input
                                        id="visit_date"
                                        name="visit_date"
                                        type="date"
                                        min="{{ now()->toDateString() }}"
                                        value="{{ old('visit_date') }}"
                                        required
                                        class="h-11 w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-600/20"
                                    >
                                </x-ui.field>
                            </div>
                        </div>

                        <x-ui.info-box variant="sunny">
                            Pengajuan akan diverifikasi oleh admin. Tautan pembayaran akan aktif setelah pengajuan disetujui.
                        </x-ui.info-box>

                        <div class="pt-2">
                            <x-ui.button type="submit" class="w-full">Kirim Formulir Pengajuan</x-ui.button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Kolom Kanan: Ringkasan Sticky & Alur --}}
            <div class="lg:sticky lg:top-24 lg:col-span-5 space-y-6">
                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-2">
                        <x-ui.icon name="school" class="size-5 text-primary-600" />
                        <h2 class="font-display text-lg font-bold text-ink">Ringkasan Estimasi Biaya</h2>
                    </div>

                    <div class="mt-4 space-y-2 text-sm text-ink-soft">
                        <div class="flex justify-between">
                            <span>Nama Paket</span>
                            <span class="font-semibold text-ink truncate max-w-[200px]">{{ $package->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Tarif per Peserta</span>
                            <span>Rp {{ number_format($package->price_per_participant, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Jumlah Peserta</span>
                            <span><span x-text="Number(participants || 0)"></span> orang</span>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-line pt-4">
                        <div class="flex items-baseline justify-between">
                            <span class="font-bold text-ink">Total Estimasi</span>
                            <span class="font-display text-2xl font-bold text-primary-700">
                                Rp <span x-text="(Number(participants || 0) * price).toLocaleString('id-ID')"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                    <h3 class="font-display text-base font-bold text-ink">Tahapan Pengajuan</h3>
                    <div class="mt-4 space-y-3 text-xs text-ink-soft">
                        <div class="flex items-start gap-2.5">
                            <span class="flex size-5 shrink-0 items-center justify-center rounded-full bg-primary-100 font-bold text-primary-800">1</span>
                            <span class="leading-relaxed">Kirim data pengajuan rombongan sekolah.</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="flex size-5 shrink-0 items-center justify-center rounded-full bg-primary-100 font-bold text-primary-800">2</span>
                            <span class="leading-relaxed">Tinjauan ketersediaan kuota oleh tim operasional.</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="flex size-5 shrink-0 items-center justify-center rounded-full bg-primary-100 font-bold text-primary-800">3</span>
                            <span class="leading-relaxed">Pembayaran dibuka setelah status disetujui.</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <span class="flex size-5 shrink-0 items-center justify-center rounded-full bg-primary-100 font-bold text-primary-800">4</span>
                            <span class="leading-relaxed">E-ticket rombongan langsung diterbitkan.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
