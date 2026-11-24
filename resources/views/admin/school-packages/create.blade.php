@extends('layouts.admin')

@section('title', 'Tambah Paket Sekolah')

@section('content')
    @php
        $package = null;
    @endphp
    <div class="mx-auto max-w-2xl">
        <x-ui.page-header
            title="Tambah Paket Sekolah"
            subtitle="Buat program paket kunjungan edukasi baru untuk rombongan sekolah."
        />
        <div class="mt-8 rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
            @include('admin.school-packages._form')
        </div>
    </div>
@endsection
