@extends('layouts.app')
@section('title')
    Barta
@endsection

{{-- @section('nav')
    @include('profile.partials.nav')
@endsection --}}
@section('content')
{!!displayAlert()!!}
    @include('home.partials.post_edit')
@endsection
@section('footer')
    @include('home.partials.footer')
@endsection
