@extends('layouts.admin')

@section('title', 'Edit Paket Sekolah')

@section('content')
    <div class="mx-auto max-w-3xl">
        <x-ui.page-header title="Edit Paket Sekolah" :subtitle="$package->name" />
        <x-ui.card class="mt-7">@include('admin.school-packages._form')</x-ui.card>
    </div>
@endsection
