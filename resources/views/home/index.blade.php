@extends('layouts.app')
@section('title')
    Barta
@endsection

{{-- @section('nav')
    @include('profile.partials.nav')
@endsection --}}
@section('content')
    {!!displayAlert()!!}
@endsection

@section('post_card')
    @include('home.partials.post_card')
@endsection
@section('barta_card')
    @include('home.partials.barta_card')
@endsection
@section('footer')
    @include('home.partials.footer')
@endsection
