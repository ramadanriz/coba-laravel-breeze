<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Data Pendapatan') }}
            </h2>
            <a href="/income/create" class="py-2 px-3 rounded-lg text-white bg-purple-500 shadow-lg hover:bg-purple-600">Add New Data</a>
        </div>
    </x-slot>

    @if($incomes->count())
    {{-- <div class="table-responsive">
      <table class="table table-hover my-0">
        <thead>
          <tr>
            <th class="d-none d-md-table-cell">No.</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Pendapatan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($incomes as $index => $income)
          <tr>
            <td class="d-none d-md-table-cell">{{ $index + $incomes->firstItem() }}</td>
            <td> @lang('income.month.'.$income->month)</td>
            <td>{{ $income->year }}</td>
            <td>@currency($income->income)</td>
            <td>
              <a href="/income/{{ $income->id }}/edit" class="badge bg-warning"><i data-feather="edit"></i></a>
              <form action="/income/{{ $income->id }}" method="POST" class="d-inline">
                @method('delete')
                @csrf
                <button class="badge bg-danger border-0" onclick="return confirm('Yakin ingin dihapus?')"><i data-feather="trash-2"></i></button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div> --}}
    
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
                  <a href="/income/{{ $income->id }}/edit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                  <form action="/income/{{ $income->id }}" method="POST" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="hover:underline text-red-500" onclick="return confirm('Yakin ingin dihapus?')">Delete</button>
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
