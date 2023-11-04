<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Barta')</title>
    @yield('links')


    @section('styles')
        @yield('styles')
    @show

</head>

<body class="bg-gray-100">
    <header>
        <!-- Navigation -->
        <nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow">
            @yield('nav')
        </nav>
    </header>

    <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
        @yield('cover_content')

        <!-- Barta Create Post Card -->
        @yield('post_card')
        <!-- /Barta Create Post Card -->

        <!-- User Specific Posts Feed -->
        @yield('user_post')
        <!-- User Specific Posts Feed -->
    </main>

    <footer class="shadow bg-black mt-10">
        @yield('footer')
    </footer>
</body>

</html>
