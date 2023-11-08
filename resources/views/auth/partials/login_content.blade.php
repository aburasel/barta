<form class="space-y-6" action="{{ route('auth.login') }}" method="POST">
    @csrf
    <ul class="text-red-500 text-xs">

        {{-- @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            
        @endif --}}
        @if (Session::has('error'))
            <p class="text-red-500 text-xs">{{ Session::get('error') }}</p>
        @endif


    </ul>
    <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email" maxlength="64"
                placeholder="bruce@wayne.com" value="{{ old('email') }}" required
                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
        </div>
        @error('email')
            <div class="text-red-500 text-xs">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <div class="flex items-center justify-between">
            <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
            <div class="text-sm">
                <a href="#" class="font-semibold text-black hover:text-black">Forgot password?</a>
            </div>
        </div>
        <div class="mt-2">
            <input id="password" name="password" type="password" maxlength="32" value="{{ old('password') }}"
                autocomplete="current-password" placeholder="••••••••" required
                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
        </div>
        @error('password')
            <div class="text-red-500 text-xs">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <button type="submit"
            class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
            Sign in
        </button>
    </div>
</form>

<p class="mt-10 text-center text-sm text-gray-500">
    Don't have an account yet?
    <a href="{{route('auth.register')}}" class="font-semibold leading-6 text-black hover:text-black">Sign Up</a>
</p>
