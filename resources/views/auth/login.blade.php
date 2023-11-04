@extends('layouts.auth')

@section('title')
    Login
@endsection

@section('styles')
    @include('auth.partials.styles')
    @parent
    {{-- Add any other style needed here --}}
@endsection

@section('content_header')
    @include('auth.partials.login_content_header')
@endsection

@section('content')
    @include('auth.partials.login_content')
@endsection
