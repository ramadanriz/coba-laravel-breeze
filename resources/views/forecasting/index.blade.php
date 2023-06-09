<x-app-layout>
    <x-slot name="header">
      <h2 class="text-xl font-semibold leading-tight capitalize">
        {{ __('Forecasting') }}
      </h2>
    </x-slot>

    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg dark:bg-gray-800">
      <div class="max-w-xl">
        <section>
          <header>
              <h2 class="text-lg font-medium">
                  {{ __('Masukkan Jangka Periode') }}
              </h2>
      
              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                  {{ __("Jumlah periode dalam moving average adalah jumlah data yang digunakan untuk menghitung rata-rata bergerak pada suatu periode waktu tertentu.") }}
              </p>
          </header>
      
          <form method="POST" action="/forecasting" class="mt-6 space-y-6">
              @csrf      
              <div class="space-y-2">       
                <x-form.input
                  id="periode"
                  name="periode"
                  type="number"
                  class="block w-full"
                  min="1"
                  max="{{ $index-1 }}"
                  value="{{ request('periode') }}"
                  required
                />
              </div>

              <div class="flex items-center gap-4">
                <x-button name="generate" type="submit">{{ __('Submit') }}</x-button>
              </div>
          </form>
        </section>      
      </div>
    </div>  

    @if (isset($_POST['generate']))
    {{-- @dd(end($data2)) --}}
    <div class="container grid gap-7 mt-8">
      <h2 class="text-xl font-semibold leading-tight capitalize">
        {{ __('Peramalan') }} Menggunakan {{ $_POST['periode'] }} Periode
      </h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 w-full">
        <div class="flex items-center p-4 w-full bg-white dark:bg-dark-eval-1 rounded-lg overflow-hidden shadow hover:shadow-md">
          <div>
            <p class="font-bold text-gray-800 dark:text-white">@currency(end($data2))</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Prediksi bulan {{ $nextPeriod }}</p>
          </div>
        </div>
        <div class="flex items-center p-4 w-full bg-white dark:bg-dark-eval-1 rounded-lg overflow-hidden shadow hover:shadow-md">
          <div>
            <p class="font-bold text-gray-800 dark:text-white">@currency($hasil['MFE'])</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase">mfe</p>
          </div>
        </div>
        <div class="flex items-center p-4 w-full bg-white dark:bg-dark-eval-1 rounded-lg overflow-hidden shadow hover:shadow-md">
          <div>
            <p class="font-bold text-gray-800 dark:text-white">@currency($hasil['MAD'])</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase">mad</p>
          </div>
        </div>
        <div class="flex items-center p-4 w-full bg-white dark:bg-dark-eval-1 rounded-lg overflow-hidden shadow hover:shadow-md">
          <div>
            <p class="font-bold text-gray-800 dark:text-white">@currency($hasil['MSE'])</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase">mse</p>
          </div>
        </div>
        <div class="flex items-center p-4 w-full bg-white dark:bg-dark-eval-1 rounded-lg overflow-hidden shadow hover:shadow-md">
          <div>
            <p class="font-bold text-gray-800 dark:text-white">{{ $hasil['MAPE'] }}%</p>
            <p class="text-sm text-gray-600 dark:text-gray-400 uppercase">mape</p>
          </div>
        </div>
      </div>
      
      <div class="overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white dark:bg-dark-eval-1">
          <h2 class="text-xl font-semibold leading-tight">
              {{ __('Grafik Perbandingan') }}
          </h2>
          <canvas id="myChart"></canvas>
      </div>

      <div class="grid gap-2">
        <h2 class="text-xl font-semibold leading-tight capitalize">
          {{ __('tabel hasil forecasting') }}
        </h2>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
          <table class="w-full text-sm text-left">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-white">
                  <tr>
                      <th scope="col" class="px-6 py-3">No</th>
                      <th scope="col" class="px-6 py-3">Periode</th>
                      <th scope="col" class="px-6 py-3">Data Aktual</th>
                      <th scope="col" class="px-6 py-3">Data Forecasting</th>
                      <th scope="col" class="px-6 py-3">Error</th>
                      <th scope="col" class="px-6 py-3">|Error|</th>
                      <th scope="col" class="px-6 py-3">Error^2</th>
                      <th scope="col" class="px-6 py-3">%Error</th>
                  </tr>
              </thead>
              <tbody>
              @for ($i=0; $i <  count($hasil['data']) ; $i++)
                <tr class="bg-white border-b dark:bg-dark-eval-1 dark:border-gray-700">
                  <td class="px-6 py-4">{{ $i+1 }}</td>
                  <td class="px-6 py-4">{{ $hasil['data'][$i][0] }}</td>
                  <td class="px-6 py-4">@currency($hasil['data'][$i][1])</td>
                  <td class="px-6 py-4">@currency($hasil['MA'][$i])</td>
                  <td class="px-6 py-4">@currency($hasil['error'][$i])</td>
                  <td class="px-6 py-4">@currency($hasil['abs'][$i])</td>
                  <td class="px-6 py-4">@currency($hasil['pow'][$i])</td>
                  <td class="px-6 py-4">{{ $hasil['percent'][$i] }}</td> 
              </tr>
              @endfor
              </tbody>
          </table>
      </div>
      </div>
    </div>

    <script>
      const ctx = document.getElementById('myChart');
    
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: <?= json_encode($labelLastTwelve = array_splice($label, -13)); ?>,
          datasets: [
              {
                  label: 'Pola Data Pendapatan',
                  data: <?= json_encode($data1Twelve); ?>,
                  borderWidth: 1
              },
              {
                  label: 'Pola Data Ramalan',
                  data: <?= json_encode(array_splice($data2, -13)); ?>,
                  borderWidth: 1
              }
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    </script>
    @endif
    
</x-app-layout>