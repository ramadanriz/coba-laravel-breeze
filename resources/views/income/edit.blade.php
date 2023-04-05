<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Tambah Data Baru') }}
            </h2>
        </div>
    </x-slot>

    <form method="POST" action="/income/{{ $income->id }}" class="max-w-2xl">
        @method('put')
        @csrf
        <div class="mb-4">
            <label for="month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bulan</label>
            <select id="month" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="month" name="month" value="{{ old('month') }}" required>
                @foreach ($months as $month)
                <option value="{{ $month }}" {{ ($income->month == $month) ? 'selected' : '' }}>@lang('income.month.'.$month)</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tahun</label>
            <input type="number" name="year" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="year" name="year" value="{{ old('year', $income->year) }}" required />
            @error('year')
            <span class="inline-flex text-sm text-red-700">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <label for="income" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pendapatan</label>
            <input type="number" name="income" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="income" name="income" value="{{ old('income', $income->income) }}" required />
        </div>
        <button type="submit" class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">Submit</button>
    </form>
</x-app-layout>