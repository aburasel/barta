@extends('layouts.app')
@section('title')
    Barta
@endsection

{{-- @section('nav')
    @include('profile.partials.nav')
@endsection --}}
@section('content')
{!!displayAlert()!!}
    @include('home.partials.single_post')
@endsection
@section('footer')
    @include('home.partials.footer')
@endsection
