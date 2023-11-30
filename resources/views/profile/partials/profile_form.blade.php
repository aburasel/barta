{{ session('error') }}

<form action="{{ route('profile.update') }}"  enctype="multipart/form-data" method="POST">
    @csrf
    @method('patch')
    <div class="space-y-12">
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-xl font-semibold leading-7 text-gray-900">
                Edit Profile
            </h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">
                This information will be displayed publicly so be careful what you
                share.
            </p>
            <div class="col-span-full mt-10 pb-10">
                <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">Photo</label>
                <div class="mt-2 flex items-center gap-x-3">
                    <input class="hidden" type="file" name="avatar" id="avatar" />
                    @php
                    if(is_null($user->avatar)){
                        $path=config('constants.DEFAULT_AVATAR_IMAGE_PATH');
                    }else{
                        $path= $user->avatar;
                    }
                    @endphp
                    <img class="h-32 w-32 rounded-full" src="{{ asset('storage/'.$path)}}"
                        alt="{{ $user->getFullName() }}" />
                    <label for="avatar">
                        <div
                            class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Change
                        </div>
                    </label>
                </div>
            </div>
            <div class="mt-10 border-b border-gray-900/10 pb-12">

                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="first_name" class="block text-sm font-medium leading-6 text-gray-900">First
                            name</label>
                        <div class="mt-2">
                            <input type="text" name="first_name" required max="32" id="first_name"
                                autocomplete="given-name"
                                value="{{ old('first_name') ? old('first_name') : $user->first_name }}"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                            @error('first_name')
                                <div class="text-red-500 text-xs">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <input type="hidden" name="id" value="{{ $user->id }}" />
                    <div class="sm:col-span-3">
                        <label for="last_name" class="block text-sm font-medium leading-6 text-gray-900">Last
                            name</label>
                        <div class="mt-2">
                            <input type="text" name="last_name" id="last_name" required max="32"
                                value="{{ old('last_name') ? old('last_name') : $user->last_name }}"
                                autocomplete="family-name"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                            @error('last_name')
                                <div class="text-red-500 text-xs">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                            address</label>
                        <div class="mt-2">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                max="64" value="{{ old('email') ? old('email') : $user->email }}"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                            @error('email')
                                <div class="text-red-500 text-xs">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Email
                            address</label>
                        <div class="mt-2">
                            <input id="username" name="username" type="text" autocomplete="username" required
                                max="32" value="{{ old('username') ? old('username') : $user->username }}"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                            @error('username')
                                <div class="text-red-500 text-xs">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                        <div class="mt-2">
                            <input type="password" name="password" id="password" autocomplete="password" required
                                value="{{ old('password') }}" maxlength="32"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                            @error('password')
                                <div class="text-red-500 text-xs">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="col-span-full">
                    <label for="bio" class="block text-sm font-medium leading-6 text-gray-900">Bio</label>
                    <div class="mt-2">
                        <textarea id="bio" name="bio" rows="3" maxlength="128"
                            class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">{{ old('bio') ? old('bio') : $user->bio }}</textarea>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        Write a few sentences about yourself.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="{{ route('profile', $user->id) }}" type="button">
            Cancel
        </a>
        <button type="submit"
            class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
            Save
        </button>
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600">{{ __('Saved.') }}</p>
        @endif
    </div>
</form>
