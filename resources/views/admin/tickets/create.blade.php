@extends('layouts.admin')

@section('title', 'Tambah Tiket')

@section('content')
    @php($ticket = null)
    <div class="mx-auto max-w-3xl">
        <x-ui.page-header title="Tambah Tiket" subtitle="Isi informasi tiket yang akan ditampilkan di katalog." />
        <x-ui.card class="mt-7">@include('admin.tickets._form')</x-ui.card>
    </div>
@endsection
