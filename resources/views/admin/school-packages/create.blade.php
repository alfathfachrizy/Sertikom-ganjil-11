@extends('layouts.admin')

@section('title', 'Tambah Paket Sekolah')

@section('content')
    @php($package = null)
    <div class="mx-auto max-w-3xl">
        <x-ui.page-header title="Tambah Paket Sekolah" subtitle="Masukkan informasi paket kunjungan rombongan." />
        <x-ui.card class="mt-7">@include('admin.school-packages._form')</x-ui.card>
    </div>
@endsection
