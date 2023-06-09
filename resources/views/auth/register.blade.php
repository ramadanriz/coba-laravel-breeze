<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="grid gap-6">
                <!-- Name -->
                <div class="space-y-2">
                    <x-form.label
                        for="name"
                        :value="__('Name')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-user aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="name"
                            class="block w-full"
                            type="text"
                            name="name"
                            :value="old('name')"
                            
                            autofocus
                            placeholder="{{ __('Name') }}"
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Username -->
                <div class="space-y-2">
                    <x-form.label
                        for="username"
                        :value="__('Username')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-user aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="username"
                            class="block w-full"
                            type="text"
                            name="username"
                            :value="old('username')"
                            
                            placeholder="{{ __('Username') }}"
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Email Address -->
                <div class="space-y-2">
                    <x-form.label
                        for="email"
                        :value="__('Email')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-envelope aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="email"
                            class="block w-full"
                            type="email"
                            name="email"
                            :value="old('email')"
                            
                            placeholder="{{ __('Email') }}"
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <x-form.label
                        for="password"
                        :value="__('Password')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-lock-closed aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="password"
                            class="block w-full"
                            type="password"
                            name="password"
                            
                            autocomplete="new-password"
                            placeholder="{{ __('Password') }}"
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <x-form.label
                        for="password_confirmation"
                        :value="__('Confirm Password')"
                    />

                    <x-form.input-with-icon-wrapper>
                        <x-slot name="icon">
                            <x-heroicon-o-lock-closed aria-hidden="true" class="w-5 h-5" />
                        </x-slot>

                        <x-form.input
                            withicon
                            id="password_confirmation"
                            class="block w-full"
                            type="password"
                            name="password_confirmation"
                            
                            placeholder="{{ __('Confirm Password') }}"
                        />
                    </x-form.input-with-icon-wrapper>
                </div>

                <!-- Choose Role -->
                <div class="space-y-2">
                    <x-form.label for="is_admin" :value="__('Role')" />
                    <select name="is_admin" id="is_admin" class="block w-full py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring
                    focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1
                    dark:text-gray-300 dark:focus:ring-offset-dark-eval-1">
                        <option value="1">Admin</option>
                        <option value="0">User</option>
                    </select>
                </div>

                <div>
                    <x-button class="justify-center w-full gap-2">
                        <x-heroicon-o-user-plus class="w-6 h-6" aria-hidden="true" />

                        <span>{{ __('Register') }}</span>
                    </x-button>
                </div>

                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Already registered?') }}
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                        {{ __('Login') }}
                    </a>
                </p>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
