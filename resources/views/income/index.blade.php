<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <div class="grid gap-2">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Data Pendapatan Bulanan') }}
            </h2>
            <form action="/income">
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
      <table class="w-full text-sm text-left text-gray-700 dark:text-gray-400">
          <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
              <tr class="text-center">
                  <th scope="col" class="px-6 py-3">No</th>
                  <th scope="col" class="px-6 py-3">Periode</th>
                  <th scope="col" class="px-6 py-3">Pendapatan</th>
                  <th scope="col" class="px-6 py-3">Action</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($incomes as $index => $income)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 text-center">
              <td class="px-6 py-4">{{ $incomes->firstItem() + $index }}</td>
              <td class="px-6 py-4">@lang('income.month.'.\Carbon\Carbon::createFromDate(null, $income->month, null)->format('F')) ({{ $income->year }})</td>
              <td class="px-6 py-4">@currency($income->total)</td>
              <td><a href="/income/{{ $income->month }}{{ $income->year }}" class="hover:underline hover:dark:text-white transition-all">Detail</a></td>
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
