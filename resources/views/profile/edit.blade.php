@extends('layouts.public')

@section('title', 'Profil Saya')

@section('content')
    <div class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
        <x-ui.page-header title="Pengaturan Profil" subtitle="Perbarui informasi akun dan keamanan kata sandi Anda." />
        <div class="mt-8 space-y-6">
            <x-ui.card>
                @include('profile.partials.update-profile-information-form')
            </x-ui.card>
            <x-ui.card>
                @include('profile.partials.update-password-form')
            </x-ui.card>
            <x-ui.card class="border-red-100">
                @include('profile.partials.delete-user-form')
            </x-ui.card>
        </div>
    </div>
@endsection
