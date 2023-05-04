<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Data Users') }}
            </h2>
        </div>
    </x-slot>

    @if($users->count())
    
    <div class="overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr class="text-center">
                  <th scope="col" class="px-6 py-3">No</th>
                  <th scope="col" class="px-6 py-3">Nama</th>
                  <th scope="col" class="px-6 py-3">Username</th>
                  <th scope="col" class="px-6 py-3">Email</th>
                  <th scope="col" class="px-6 py-3">Action</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 text-center">
              <td class="px-6 py-4">{{ $loop->iteration }}</td>
              <td class="px-6 py-4">{{ $user->name }}</td>
              <td class="px-6 py-4">{{ $user->username }}</td>
              <td class="px-6 py-4">{{ $user->email }}</td>
              <td class="px-6 py-4">
                  <form action="/users/{{ $user->id }}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btndeleteuser" value="{{ $user->id }}"><x-heroicon-o-trash class="flex-shrink-0 w-6 h-6 hover:text-red-500" aria-hidden="true" /></button>
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
</x-app-layout>