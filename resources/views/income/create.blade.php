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
                                for="date"
                                :value="__('Tanggal')"
                            />
                
                            <x-form.input
                                id="date"
                                name="date"
                                type="date"
                                class="block w-full"
                                :value="old('date')"
                                required
                                autofocus
                                autocomplete="date"
                            />
                
                            <x-form.error :messages="$errors->get('date')" />
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