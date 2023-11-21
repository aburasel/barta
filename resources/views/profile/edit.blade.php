@extends('layouts.app')
@section('title')
    Edit Pofile
@endsection

@section('content')
    @include('profile.partials.profile_form')
    {{-- @include('profile.partials.update-profile-information-form') --}}
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection

@section('footer')
    @include('home.partials.footer')
@endsection
