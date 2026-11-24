@extends('layouts.admin')

@section('title', 'Tambah Tiket Baru')

@section('content')
    @php
        $ticket = null;
    @endphp
    <div class="mx-auto max-w-2xl">
        <x-ui.page-header
            title="Tambah Tiket Baru"
            subtitle="Buat produk tiket masuk reguler baru untuk pengunjung The Nice Park."
        />
        <div class="mt-8 rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
            @include('admin.tickets._form')
        </div>
    </div>
@endsection
