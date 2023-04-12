<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div class="grid gap-2">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Data Pendapatan') }}
            </h2>
            <form role="search">
              <x-form.input-with-icon-wrapper>
                <x-slot name="icon">
                  <x-heroicon-o-magnifying-glass aria-hidden="true" class="w-5 h-5" />
                </x-slot>

                <x-form.input
                    withicon
                    id="search"
                    class="block w-full"
                    type="text"
                    name="search"
                    :value="request('search')"
                    placeholder="{{ __('Search') }}"
                    autofocus
                />
              </x-form.input-with-icon-wrapper>
            </form>
          </div>
          <a href="/income/create" class="py-2 px-3 rounded-lg text-white bg-purple-500 shadow-lg hover:bg-purple-600">Add New Data</a>
        </div>
    </x-slot>

    @if($incomes->count())
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr class="text-center">
                  <th scope="col" class="px-6 py-3">No</th>
                  <th scope="col" class="px-6 py-3">Bulan</th>
                  <th scope="col" class="px-6 py-3">Tahun</th>
                  <th scope="col" class="px-6 py-3">Pendapatan</th>
                  <th scope="col" class="px-6 py-3">Action</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($incomes as $index => $income)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 text-center">
              <td class="px-6 py-4">{{ $index + $incomes->firstItem() }}</td>
              <td class="px-6 py-4">@lang('income.month.'.$income->month)</td>
              <td class="px-6 py-4">{{ $income->year }}</td>
              <td class="px-6 py-4">@currency($income->income)</td>
              <td class="px-6 py-4 flex justify-around">
                  <a href="/income/{{ $income->id }}/edit"><x-heroicon-o-pencil-square class="flex-shrink-0 w-6 h-6 hover:text-blue-500" aria-hidden="true" /></a>
                  <form action="/income/{{ $income->id }}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btndelete" value="{{ $income->id }}"><x-heroicon-o-trash class="flex-shrink-0 w-6 h-6 hover:text-red-500" aria-hidden="true" /></button>
                  </form>
              </td>
          </tr>
          @endforeach              
          </tbody>
      </table>
    </div>
    @else
    <p class="text-center text-lg">Tidak ada Data</p>
    @endif
    {{ $incomes->links() }}      
</x-app-layout>
