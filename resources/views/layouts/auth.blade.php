<!DOCTYPE html>
<html class="html h-full bg-white">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Barta')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @section('styles')
        @yield('common_styles')
    @show
    {{-- Note @show used. Not @endsection --}}
</head>

<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            @yield('content_header')
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @yield('content')
        </div>
    </div>
</body>

</html>
