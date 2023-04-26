<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="grid gap-6">
                <!-- Email or Username -->
                <div class="space-y-2">
                    <x-form.label
                        for="input_type"
                        :value="__('Email/Username')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-user aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="input_type"
                            class="block w-full"
                            type="text"
                            name="input_type"
                            :value="old('input_type')"
                            placeholder="{{ __('Email/Username') }}"
                            autofocus
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Password -->
                
                <div class="space-y-2" x-data="{ show: true }">
                    <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Password</label>

                    <div class="relative text-gray-500 focus-within:text-gray-900 dark:focus-within:text-gray-400">
                        <div aria-hidden="true" class="absolute inset-y-0 flex items-center px-4 pointer-events-none">
                            <x-heroicon-o-lock-closed aria-hidden="true" class="w-5 h-5" />
                        </div>
                        <input :type="show ? 'password' : 'text'" class="py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 pl-11 pr-16 block w-full" id="password" name="password" autocomplete="current-password" placeholder="{{ __('Password') }}" />
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5 cursor-pointer" @click="show= !show">
                            <x-heroicon-o-eye x-show="show" class="w-5 h-5" />
                            <x-heroicon-o-eye-slash x-show="!show" class="w-5 h-5" />
                        </button>
                    </div>                    
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="text-purple-500 border-gray-300 rounded focus:border-purple-300 focus:ring focus:ring-purple-500 dark:border-gray-600 dark:bg-dark-eval-1 dark:focus:ring-offset-dark-eval-1"
                            name="remember"
                        >

                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Remember me') }}
                        </span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div>
                    <x-button class="justify-center w-full gap-2">
                        <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6" aria-hidden="true" />

                        <span>{{ __('Log in') }}</span>
                    </x-button>
                </div>

                @if (Route::has('register'))
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Don’t have an account?') }}
                        <a href="{{ route('register') }}" class="text-blue-500 hover:underline">
                            {{ __('Register') }}
                        </a>
                    </p>
                @endif
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
