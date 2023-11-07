<!DOCTYPE html>
<html class="html h-full bg-white">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'Barta')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @section('links')
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @show
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>


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
