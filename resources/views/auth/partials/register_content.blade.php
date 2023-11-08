<form class="space-y-6" action="{{ route('auth.register') }}" method="POST">
    @csrf
    <!-- First Name -->
    {{-- {{ print_r($errors->all()) }} --}}
    <div>
        <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
        <div class="mt-2">
            <input id="first_name" name="first_name" type="text" autocomplete="first_name" placeholder="Muhammad"
                required max="32" value="{{ old('first_name') }}"
                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6 " />
            @error('first_name')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <!-- First Name -->
    <div>
        <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
        <div class="mt-2">
            <input id="last_name" name="last_name" type="text" autocomplete="last_name" placeholder="Alp Arslan"
                required max="32" value="{{ old('last_name') }}"
                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
            @error('last_name')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email address</label>
        <div class="mt-2">
            <input id="email" name="email" type="email" autocomplete="email" placeholder="alp.arslan@mail.com"
                required max="64" value="{{ old('email') }}"
                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
            @error('email')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <!-- Password -->
    <div>
        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
        <div class="mt-2">
            <input id="password" name="password" type="password" maxlength="32" autocomplete="current-password"
                placeholder="••••••••" required value="{{ old('password') }}"
                class="block w-full rounded-md border-0 p-2 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-black sm:text-sm sm:leading-6" />
            @error('password')
                <div class="text-red-500 text-xs">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div>
        <button type="submit"
            class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
            Register
        </button>
    </div>
</form>

<p class="mt-10 text-center text-sm text-gray-500">
    Already a member?
    <a href="{{route('login')}}" class="font-semibold leading-6 text-black hover:text-black">Sign In</a>
</p>
