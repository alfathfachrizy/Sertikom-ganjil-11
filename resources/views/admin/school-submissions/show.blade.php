@extends('layouts.admin')

@section('title', 'Tinjau Pengajuan Sekolah')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <x-ui.page-header
            title="Tinjau Pengajuan Kunjungan"
            :subtitle="'Sekolah: ' . $submission->school_name"
        />
        <x-ui.status-badge :status="$submission->status" class="self-start sm:self-auto" />
    </div>

    {{-- Layout Dua Kolom: Kiri data pengajuan, Kanan panel keputusan --}}
    <div class="mt-8 grid grid-cols-1 items-start gap-8 lg:grid-cols-12">
        {{-- Data Pengajuan di Kiri --}}
        <div class="space-y-6 lg:col-span-8">
            <div class="rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
                <h2 class="font-display text-xl font-bold text-ink border-b border-line pb-3">Informasi Sekolah & Rombongan</h2>
                <dl class="mt-4 grid grid-cols-1 gap-4 text-sm sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Nama Sekolah</dt>
                        <dd class="mt-1 font-bold text-ink break-words">{{ $submission->school_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Penanggung Jawab (PIC)</dt>
                        <dd class="mt-1 font-bold text-ink">{{ $submission->pic_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Nomor Telepon PIC</dt>
                        <dd class="mt-1 font-bold text-ink">{{ $submission->pic_phone }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Jumlah Peserta</dt>
                        <dd class="mt-1 font-bold text-ink">{{ number_format($submission->participant_count, 0, ',', '.') }} orang</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Rencana Tanggal Kunjungan</dt>
                        <dd class="mt-1 font-bold text-primary-700">{{ $submission->order->visit_date->translatedFormat('d F Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Akun Pemohon</dt>
                        <dd class="mt-1 font-semibold text-ink">{{ $submission->order->user->name }} ({{ $submission->order->user->email }})</dd>
                    </div>
                </dl>

                <div class="mt-8 border-t border-line pt-6">
                    <h3 class="font-display text-lg font-bold text-ink">Paket yang Dipilih (Kode: {{ $submission->order->order_code }})</h3>
                    <div class="mt-4 space-y-3">
                        @foreach ($submission->order->items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-ink">{{ $item->schoolPackage?->name ?? 'Paket Sekolah' }} × {{ number_format($item->quantity, 0, ',', '.') }} peserta</span>
                                <span class="font-bold text-ink">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 border-t border-line pt-4 flex justify-between items-baseline">
                        <span class="font-bold text-ink">Total Tagihan</span>
                        <span class="font-display text-2xl font-bold text-primary-700">Rp {{ number_format($submission->order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel Keputusan di Kanan --}}
        <div class="lg:col-span-4" x-data="{ rejectModalOpen: false }">
            <div class="rounded-2xl border border-line bg-white p-6 shadow-sm">
                <h3 class="font-display text-lg font-bold text-ink border-b border-line pb-3">Keputusan Admin</h3>

                @if ($submission->status === 'pending')
                    <p class="mt-3 text-sm text-ink-soft leading-relaxed">
                        Pastikan tanggal dan kuota operasional tersedia sebelum menyetujui pengajuan kunjungan rombongan ini.
                    </p>

                    <div class="mt-6 space-y-3">
                        <form method="POST" action="{{ route('admin.school-submissions.approve', $submission) }}">
                            @csrf
                            <x-ui.button type="submit" class="w-full">
                                <x-ui.icon name="check-circle" class="size-4" />
                                <span>Setujui Pengajuan</span>
                            </x-ui.button>
                        </form>

                        <x-ui.button type="button" variant="ghost" class="w-full text-red-600 hover:bg-red-50 hover:text-red-700" @click="rejectModalOpen = true">
                            <x-ui.icon name="x-circle" class="size-4" />
                            <span>Tolak Pengajuan</span>
                        </x-ui.button>
                    </div>

                    {{-- Modal Tolak Alpine.js --}}
                    <div
                        x-show="rejectModalOpen"
                        x-cloak
                        class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-0"
                        role="dialog"
                        aria-modal="true"
                    >
                        <div class="fixed inset-0 bg-ink/60 backdrop-blur-xs" @click="rejectModalOpen = false"></div>
                        <div class="relative mx-auto max-w-lg rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-md">
                            <h3 class="font-display text-xl font-bold text-ink">Tolak Pengajuan Sekolah</h3>
                            <p class="mt-2 text-sm text-ink-soft">Tuliskan alasan penolakan secara jelas agar pemohon dapat mengetahuinya.</p>

                            <form method="POST" action="{{ route('admin.school-submissions.reject', $submission) }}" class="mt-4 space-y-4">
                                @csrf
                                <x-ui.field name="rejection_reason" label="Alasan Penolakan">
                                    <textarea
                                        id="rejection_reason"
                                        name="rejection_reason"
                                        rows="4"
                                        required
                                        minlength="5"
                                        placeholder="Contoh: Kuota kunjungan untuk tanggal yang dipilih sudah penuh..."
                                        class="w-full rounded-xl border border-line bg-white px-4 py-2.5 text-base text-ink shadow-sm focus:border-red-600 focus:outline-none focus:ring-2 focus:ring-red-600/20"
                                    >{{ old('rejection_reason') }}</textarea>
                                </x-ui.field>

                                <div class="flex justify-end gap-3 pt-2">
                                    <x-ui.button type="button" variant="ghost" @click="rejectModalOpen = false">Batal</x-ui.button>
                                    <x-ui.button type="submit" variant="danger">Konfirmasi Tolak</x-ui.button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="mt-4 space-y-3">
                        <div class="rounded-xl border border-line bg-cream p-4 text-sm">
                            <span class="text-xs text-ink-soft uppercase tracking-wider font-semibold">Status Pengajuan</span>
                            <p class="mt-1 font-bold text-ink">Telah diproses</p>
                        </div>

                        @if ($submission->rejection_reason)
                            <x-ui.info-box variant="danger" icon="alert-triangle">
                                <div>
                                    <p class="font-bold text-red-900">Alasan Penolakan:</p>
                                    <p class="mt-1 text-sm text-red-800">{{ $submission->rejection_reason }}</p>
                                </div>
                            </x-ui.info-box>
                        @endif

                        <div class="space-y-2 text-xs text-ink-soft pt-2">
                            <p>Ditinjau oleh: <span class="font-semibold text-ink">{{ $submission->reviewer?->name ?? '—' }}</span></p>
                            <p>Waktu tinjau: <span class="font-semibold text-ink">{{ $submission->reviewed_at?->translatedFormat('d F Y, H:i') ?? '—' }}</span></p>
                        </div>
                    </div>
                @endif

                <div class="mt-6 border-t border-line pt-4">
                    <x-ui.button variant="ghost" :href="route('admin.school-submissions.index')" class="w-full">
                        <x-ui.icon name="arrow-left" class="size-4" />
                        <span>Kembali ke Daftar</span>
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>
@endsection
