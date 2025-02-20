<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="flex items-center justify-center w-full min-h-screen bg-gray-100">
        <div class="w-full max-w-lg p-10 mt-10 mb-10 bg-white border border-gray-300 rounded-lg shadow-xl">

            <!-- Logo and Title -->
            <div class="flex items-center justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="SumberArum Logo" class="w-16 h-16 mr-4">
                <h2 class="text-3xl font-bold text-center text-black">SUMBERARUM</h2>
            </div>

            <!-- Login Text -->
            <div class="mb-4 text-center">
                <h3 class="text-xl font-bold text-gray-700">Login Admin</h3>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="flex flex-col items-center mb-6">
                    <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-left text-gray-900 w-80" />
                    <x-text-input id="email" class="block px-4 py-3 mt-2 border rounded-md shadow-sm w-80 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-200 dark:border-gray-600 dark:text-gray-700"
                                  type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Password -->
                <div class="flex flex-col items-center mb-6">
                    <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-left text-gray-900 w-80 " />
                    <x-text-input id="password" class="block px-4 py-3 mt-2 border rounded-md shadow-sm w-80 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-200 dark:border-gray-600 dark:text-gray-700"
                                  type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-600" />
                </div>

                <!-- Login Button -->
                <div class="flex items-center justify-center">
                    <x-primary-button class="py-3 mt-3 text-center w-80 dark:text-white dark:bg-indigo-600 focus:ring-indigo-500 ">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
