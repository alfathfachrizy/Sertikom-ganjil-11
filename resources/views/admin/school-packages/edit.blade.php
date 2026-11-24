@extends('layouts.admin')

@section('title', 'Edit Paket Sekolah')

@section('content')
    <div class="mx-auto max-w-2xl">
        <x-ui.page-header
            title="Edit Paket Sekolah"
            :subtitle="'Memperbarui rincian untuk: ' . $package->name"
        />
        <div class="mt-8 rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
            @include('admin.school-packages._form')
        </div>
    </div>
@endsection
