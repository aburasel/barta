@extends('layouts.app')
@section('title')
    Barta
@endsection

@section('content')
    @forelse ($notifications as $item)
        <p class="bg-white border-1 border-grey rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
            {{ $item->data['message'] }}...
        </p>

    @empty
        <p>No notification found</p>
    @endforelse
@endsection
@section('footer')
    @include('home.partials.footer')
@endsection
