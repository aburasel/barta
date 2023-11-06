@extends('layouts.app')
@section('title')
    Pofile
@endsection

@section('links')
    @include('main.partials.links')
@endsection
@section('styles')
    @include('main.partials.style')
@endsection
{{-- @section('nav')
    @include('main.partials.nav')
@endsection --}}
@section('cover_content')
    @include('main.partials.profile_form')
@endsection
@section('post_card')
    @include('main.partials.post_card')
@endsection
@section('user_post')
    @include('main.partials.user_post')
@endsection
@section('footer')
    @include('main.partials.footer')
@endsection
