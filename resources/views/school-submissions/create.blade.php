@extends('layouts.public')

@section('title', 'Ajukan Paket Sekolah')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        <x-ui.page-header title="Ajukan Paket Sekolah" subtitle="Ceritakan rencana kunjungan sekolahmu, tim kami akan meninjaunya." />
        <div x-data="{ participants: {{ (int) old('participant_count', $package->min_participants) }}, price: {{ (float) $package->price_per_participant }} }" class="mt-8 grid grid-cols-1 items-start gap-6 lg:grid-cols-5">
            <x-ui.card class="lg:col-span-3">
                <form method="POST" action="{{ route('school-submissions.store') }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="school_package_id" value="{{ $package->id }}">
                    <div class="rounded-2xl bg-primary-50 p-4">
                        <p class="font-display text-xl font-extrabold">{{ $package->name }}</p>
                        <p class="mt-1 font-bold text-primary-700">Rp {{ number_format($package->price_per_participant, 0, ',', '.') }} / peserta · Minimal {{ $package->min_participants }} peserta</p>
                    </div>
                    <x-ui.field name="school_name" label="Nama Sekolah">
                        <input id="school_name" name="school_name" type="text" value="{{ old('school_name') }}" required maxlength="255" class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
                    </x-ui.field>
                    <x-ui.field name="pic_name" label="Nama Penanggung Jawab">
                        <input id="pic_name" name="pic_name" type="text" value="{{ old('pic_name') }}" required maxlength="255" class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
                    </x-ui.field>
                    <x-ui.field name="pic_phone" label="Nomor HP Penanggung Jawab">
                        <input id="pic_phone" name="pic_phone" type="tel" value="{{ old('pic_phone') }}" required maxlength="20" autocomplete="tel" class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
                    </x-ui.field>
                    <x-ui.field name="participant_count" label="Jumlah Peserta" :hint="'Minimal '.$package->min_participants.' peserta.'">
                        <input id="participant_count" name="participant_count" type="number" min="1" x-model.number="participants" value="{{ old('participant_count', $package->min_participants) }}" required class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
                    </x-ui.field>
                    <x-ui.field name="visit_date" label="Tanggal Kunjungan">
                        <input id="visit_date" name="visit_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('visit_date') }}" required class="min-h-11 w-full rounded-xl border-2 border-primary-100 px-4 py-3 focus:border-primary-500 focus:ring-primary-100">
                    </x-ui.field>
                    <div>
                        <div class="flex items-center justify-between rounded-2xl bg-sunny-50 p-4">
                            <span class="font-bold">Estimasi total</span>
                            <span class="font-display text-2xl font-extrabold text-primary-700">Rp <span x-text="(Number(participants || 0) * price).toLocaleString('id-ID')"></span></span>
                        </div>
                        <p class="mt-2 text-xs text-primary-800/65">Total akhir dihitung ulang oleh server.</p>
                    </div>
                    <div class="rounded-2xl border border-sunny-200 bg-sunny-50 p-4 text-sm leading-6 text-primary-800">
                        ℹ️ Pengajuan ditinjau admin dulu, pembayaran dibuka setelah disetujui.
                    </div>
                    <x-ui.button type="submit" class="w-full">Kirim Pengajuan</x-ui.button>
                </form>
            </x-ui.card>
            <x-ui.card class="bg-gradient-to-br from-sunny-50 to-white lg:col-span-2">
                <span class="text-4xl">🏫</span>
                <h2 class="mt-3 font-display text-2xl font-extrabold">Alur Pengajuan</h2>
                <ol class="mt-5 space-y-4 text-sm text-primary-800">
                    <li><span class="mr-2 font-extrabold text-primary-600">1.</span>Lengkapi data rombongan.</li>
                    <li><span class="mr-2 font-extrabold text-primary-600">2.</span>Admin meninjau pengajuan.</li>
                    <li><span class="mr-2 font-extrabold text-primary-600">3.</span>Bayar setelah disetujui.</li>
                    <li><span class="mr-2 font-extrabold text-primary-600">4.</span>Gunakan e-ticket saat berkunjung.</li>
                </ol>
            </x-ui.card>
        </div>
    </div>
@endsection
