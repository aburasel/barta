<!-- Newsfeed -->
<section id="newsfeed" class="space-y-6">
    <!-- Barta Card -->
    {{-- {{ dd($posts) }} --}}
    @foreach ($users as $user)
        <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
            <!-- Barta Card Top -->
            <header>
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- User Avatar -->
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $user->avatar) }}"
                                alt="{{ $user->getFullName() }}" />
                        </div>
                        <!-- /User Avatar -->

                        <!-- User Info -->
                        <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                            <a href="{{ route('profile', $user->id) }}"
                                class="hover:underline font-semibold line-clamp-1">
                                {{ $user->getFullName() }}
                            </a>

                            <a href="{{ route('profile', $user->id) }}"
                                class="hover:underline text-sm text-gray-500 line-clamp-1">
                                {{ '@' . $user->username }}
                            </a>
                        </div>
                        <!-- /User Info -->
                    </div>

                    

                </div>
            </header>


            
        </article>
        <!-- /Barta Card -->
    @endforeach
</section>
<!-- /Newsfeed -->
