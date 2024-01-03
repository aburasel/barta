<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Barta')</title>

    @section('links')
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- AlpineJS CDN -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
        {{-- @yield('links') --}}
    @show

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>

</head>

<body class="bg-gray-100">
    <header>
        <!-- Navigation -->
        <nav x-data="{ mobileMenuOpen: false, userMenuOpen: false }" class="bg-white shadow">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <div class="flex flex-shrink-0 items-center">
                            <a href="/">
                                <h2 class="font-bold text-2xl">Barta</h2>
                            </a>
                        </div>
                    </div>
                    <!-- Search input -->
                    <form action="{{ route('profile.search') }}" method="POST" class="flex items-center">
                        @csrf
                        <input type="text" name ="search" placeholder="Search..." required
                            class="border-2 border-gray-300 bg-white h-10 px-5 pr-10 rounded-full text-sm focus:outline-none"
                            value="" />


                        <input type="submit" style="display:none" />
                    </form>
                    <div class="hidden sm:ml-6 sm:flex gap-2 sm:items-center">

                        <!-- Notification dropdown -->
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                @if (auth()->user()->unreadNotifications->count() != 0)
                                    <div
                                        class="absolute bottom-auto left-auto right-0 top-0 z-10 inline-block -translate-y-1/2 translate-x-2/4 rotate-0 skew-x-0 skew-y-0 scale-x-100 scale-y-100 whitespace-nowrap rounded-full bg-red-700 px-2.5 py-1 text-center align-baseline text-xs font-bold leading-none text-white">
                                        {{ auth()->user()->unreadNotifications->count() }}+
                                    </div>
                                @endif

                                <button @click="open = !open" type="button"
                                    class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Notification</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />

                                    </svg>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">

                                @forelse (auth()->user()->unreadNotifications as $item)
                                    <a href={{ route('notifications') }}
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                        tabindex="-1"
                                        id="user-menu-item-{{ $loop->index }}">{{ $item->data['message'] }}</a>
                                @empty
                                    <p>No Notifications</p>
                                @endforelse

                            </div>
                        </div>
                        <!-- Profile dropdown -->
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" type="button"
                                    class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                    id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full"
                                        src="{{ asset('storage/' . auth()->user()->avatar) }}"
                                        alt="{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}" />
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <a href="{{ route('profile', auth()->user()->id) }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Edit Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                        {{ __('Sign out') }}
                                    </x-dropdown-link>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="-mr-2 flex items-center sm:hidden">
                        <!-- Mobile menu button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-500"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Icon when menu is closed -->
                            <svg x-show="!mobileMenuOpen" class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>

                            <!-- Icon when menu is open -->
                            <svg x-show="mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div x-show="mobileMenuOpen" class="sm:hidden" id="mobile-menu">
                <div class="border-t border-gray-200 pt-4 pb-3">
                    <div class="flex items-center px-4">
                        <div>
                            <div class="text-base font-medium text-gray-800">
                                {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile', auth()->user()->id) }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Your
                            Profile</a>
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-800">Edit
                            Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                {{ __('Sign out') }}
                            </x-dropdown-link>
                        </form>


                    </div>
                </div>
            </div>

        </nav>
    </header>

    <main class="container max-w-2xl mx-auto space-y-8 mt-8 px-2 min-h-screen">
        @yield('content')
        <!-- Barta Create Post Card -->
        @yield('post_card')
        <!-- /Barta Create Post Card -->

        <!-- User Specific Posts Feed -->
        @yield('barta_card')
        <!-- User Specific Posts Feed -->
    </main>

    <footer class="shadow bg-black mt-10">
        @yield('footer')
    </footer>
</body>

</html>

{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> --}}
