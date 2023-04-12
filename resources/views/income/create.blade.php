<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight capitalize">
                {{ __('data pendapatan') }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
            <div class="max-w-xl">
                <section>
                    <header>
                        <h2 class="text-lg font-medium capitalize">
                            {{ __('add new income data') }}
                        </h2>
                
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            {{ __("Tambahkan data pendapatan disini.") }}
                        </p>
                    </header>

                    <form method="POST" action="/income" class="mt-6 space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <x-form.label
                                for="month"
                                :value="__('Bulan')"
                            />
                
                            <select id="month" class="py-2 border-gray-400 rounded-md focus:border-gray-400 focus:ring focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1" id="month" name="month" value="{{ old('month') }}" required>
                                @foreach ($months as $month)
                                <option value="{{ $month }}">@lang('income.month.'.$month)</option>
                                @endforeach
                            </select>
                
                            <x-form.error :messages="$errors->get('month')" />
                        </div>

                        <div class="space-y-2">
                            <x-form.label
                                for="year"
                                :value="__('Tahun')"
                            />
                
                            <x-form.input
                                id="year"
                                name="year"
                                type="number"
                                class="block w-full"
                                :value="old('year')"
                                required
                                autofocus
                                autocomplete="year"
                            />
                
                            <x-form.error :messages="$errors->get('year')" />
                        </div>

                        <div class="space-y-2">
                            <x-form.label
                                for="income"
                                :value="__('Pendapatan')"
                            />
                
                            <x-form.input
                                id="income"
                                name="income"
                                type="number"
                                class="block w-full"
                                :value="old('income')"
                                required
                                autofocus
                                autocomplete="income"
                            />
                
                            <x-form.error :messages="$errors->get('income')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-button
                                type="submit"
                            >
                                {{ __('Save') }}
                            </x-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>