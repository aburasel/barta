@extends('layouts.auth')

@section('title')
    Registration
@endsection

@section('styles')
    @include('auth.partials.styles')
    @parent
    {{-- Add any other style needed here --}}
@endsection

@section('content_header')
    @include('auth.partials.register_content_header')
@endsection

@section('content')
    @include('auth.partials.register_content')
@endsection
