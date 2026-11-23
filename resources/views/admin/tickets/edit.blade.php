@extends('layouts.admin')

@section('title', 'Edit Tiket')

@section('content')
    <div class="mx-auto max-w-3xl">
        <x-ui.page-header title="Edit Tiket" :subtitle="$ticket->name" />
        <x-ui.card class="mt-7">@include('admin.tickets._form')</x-ui.card>
    </div>
@endsection
