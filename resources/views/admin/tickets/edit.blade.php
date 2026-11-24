@extends('layouts.admin')

@section('title', 'Edit Tiket')

@section('content')
    <div class="mx-auto max-w-2xl">
        <x-ui.page-header
            title="Edit Tiket"
            :subtitle="'Memperbarui rincian untuk: ' . $ticket->name"
        />
        <div class="mt-8 rounded-2xl border border-line bg-white p-6 sm:p-8 shadow-sm">
            @include('admin.tickets._form')
        </div>
    </div>
@endsection
