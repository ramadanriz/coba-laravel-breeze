<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminForecastingController extends Controller
{
    public function index() {
        $data = $this->getData();
        $index = count($data);
        $label = [];
        $data1 = [];
        $data2 = [];
        if (isset($_POST['generate'])) {
          $nextPeriod = $this->label_now();
          $periode =  $_POST['periode'];
          $hasil = $this->countStart($data,$periode);
    
            foreach ($data as $value) {
                array_push($label,$value[0]);
                array_push($data1,$value[1]);
            }
    
            foreach ($hasil['MA'] as $value) {
                array_push($data2,$value);
            }
        }

        return view('forecasting.index', [
            "hasil" => isset($_POST['generate']) ? $hasil : '',
            "index" => $index,
            "label" => isset($_POST['generate']) ? $label : '',
            "data1" => isset($_POST['generate']) ? $data1 : '',
            "data2" => isset($_POST['generate']) ? $data2 : '',
            "nextPeriod" => isset($_POST['generate']) ? $nextPeriod : ''
        ]);
      }
    
      public function getData() {
        // $data = Income::all();
        // $output = [];
        // foreach ($data as $row) {
        //     $output[] = [
        //         trans('income.month.'.$row->month).' ('.$row->year.')',
        //         $row->income
        //     ];
        // }
    
        // return $output;

        $data = Income::select([
          DB::raw('sum(income) as total'),
          DB::raw('EXTRACT(MONTH from date) as month'),
          DB::raw('EXTRACT(YEAR from date) as year')
        ])
          ->groupBy('month', 'year')
          ->get();

        $output = [];

        foreach($data as $income) {
          $output[] = [
            \Carbon\Carbon::createFromDate(null, $income->month)->locale('id')->monthName . ' ('.$income->year.')',
            $income->total
          ];
        }

        return $output;
      }
    
      public function countStart($data,$ma) {
        $space = count($data);
        $MA = $this->MovingAverage($data, $space, $ma);
        $MFE = $this->MFE($data,$space,$ma,$MA);
        $MAD = $this->MAD($MFE['error'],$space,$ma);
        $MSE = $this->MSE($MAD['absError'],$space,$ma);
        $MAPE = $this->MAPE($data,$MAD['absError'],$space,$ma);
        
        // menambahkan 1 index ke data
        array_push($data, array($this->label_now(), NULL));
        return array(
          'data'=>$data,
          'MA'=>$MA,
          'error' => $MFE['error'],
          'MFE' => $MFE['MFE'],
          'abs' => $MAD['absError'],
          'MAD' => $MAD['MAD'],
          'pow' => $MSE['powError'],
          'MSE' => $MSE['MSE'],
          'percent' => $MAPE['percent'],
          'MAPE' => $MAPE['MAPE']
        );
      }
    
      public function MovingAverage($data,$index,$ma) {
        // sediakan tempat untuk data + 1
        // $MA = array();
        // $MA = array_fill(0,$index + 1,NULL);
    
        // // looping
        // for ($i=$ma-1; $i < $index; $i++) { 
    
        //   // inisiali dan reset temp
        //   $temp = 0;
    
        //   // temp sebanyak ma
        //   for ($j=0; $j < $ma; $j++) {
        //     $temp += $data[ $i - $j ][1];
        //   }
          
        //   // menentukan nilai rata rata MA
        //   $MA[$i+1] = round($temp/$ma);
        // }
    
        // return $MA;
    
        $MA = array_fill(0, $index + 1, NULL);
        for ($i = $ma - 1; $i < $index; $i++) { 
            $MA[$i+1] = round(array_sum(array_column(array_slice($data, $i - $ma + 1, $ma), 1)) / $ma);
        }
        return $MA;
      }
    
      public function MFE($data,$index,$ma,$MA) {
        // $error = array();
        // $error = array_fill(0,$index + 1,NULL);
        // // looping
        // for ($i=$ma; $i < $index ; $i++) { 
        //   // menentukan nilai error
        //   $error[$i] = $data[$i][1] - $MA[$i];
        // }
    
        // // memisahkan variabel null ke dalam temp
        // $tempError = $error;
        // for ($i=0; $i < $ma; $i++) { 
        //   array_shift($tempError);
        // }
    
        // // menjumlahkan nilai mutlak error
        // $tempSum = array_sum($tempError);
        // $count = count($tempError) - 1;
        // $MFE = round($tempSum / $count, 2);
    
        // return array(
        //   'error' => $error,
        //   'MFE' => $MFE
        // );
    
        // return $error;
    
        $error = array_fill(0, $index + 1, NULL);
    
        for ($i = $ma; $i < $index; $i++) { 
          $error[$i] = $data[$i][1] - $MA[$i];
        }
    
        $tempError = array_slice($error, $ma);
        $MFE = round(array_sum($tempError) / (count($tempError) - 1), 2);
    
        return array('error' => $error, 'MFE' => $MFE);
      }
    
      public function MAD($error,$index,$ma) {
        // $absError = array();
        // $absError = array_fill(0,$index + 1,NULL);
        // // looping
        // for ($i=$ma; $i < $index ; $i++) { 
        //   // menentukan nilai error
        //   $absError[$i] = abs($error[$i]);
        // }
        
        // // memisahkan variabel null ke dalam temp
        // $tempAbsError = $absError;
        // for ($i=0; $i < $ma; $i++) { 
        //   array_shift($tempAbsError);
        // }
    
        // // menjumlahkan nilai mutlak error
        // $tempSum = array_sum($tempAbsError);
        // $count = count($tempAbsError) - 1;
        // $MAD = round($tempSum / $count, 2);
    
        // return array(
        //   'absError' => $absError,
        //   'MAD' => $MAD
        // );
    
        $absError = array_fill(0, $index + 1, NULL);
    
        for ($i = $ma; $i < $index; $i++) { 
            $absError[$i] = abs($error[$i]);
        }
        
        $tempAbsError = array_slice($absError, $ma);
        $MAD = round(array_sum($tempAbsError) / (count($tempAbsError) - 1), 2);
    
        return array('absError' => $absError, 'MAD' => $MAD);
      }
    
      public function MSE($absError,$index,$ma) {
        // $powError = array();
        $powError = array_fill(0,$index + 1,NULL);
        // // looping
        // for ($i=$ma; $i < $index ; $i++) { 
        //   // menentukan nilai error
        //   $powError[$i] = pow($absError[$i],2);
        // }
        
        // // memisahkan variabel null ke dalam temp
        // $tempPowError = $powError;
        // for ($i=0; $i < $ma; $i++) { 
        //   array_shift($tempPowError);
        // }
    
        // // menjumlahkan nilai mutlak error
        // $tempPow = array_sum($tempPowError);
        // $count = count($tempPowError) - 1;
        // $MSE = round($tempPow / $count, 2);
    
        // return array(
        //   'powError' => $powError,
        //   'MSE' => $MSE
        // );
    
        for ($i = $ma; $i < $index; $i++) { 
          $powError[$i] = pow($absError[$i], 2);
        }
            
        $tempPowError = array_slice($powError, $ma);
        $MSE = round(array_sum($tempPowError) / (count($tempPowError) - 1), 2);
        
        return array('powError' => $powError, 'MSE' => $MSE);
      }
    
      public function MAPE($data,$absError,$index,$ma) {
        // $percentError = array();
        $percentError = array_fill(0,$index + 1,NULL);
        // // looping
        // for ($i=$ma; $i < $index ; $i++) { 
        //   // menentukan nilai error
        //   $percentError[$i] = round($absError[$i] / $data[$i][1] * 100 , 2);
        // }
        
        // // memisahkan variabel null ke dalam temp
        // $tempPercentError = $percentError;
        // for ($i=0; $i < $ma; $i++) { 
        //   array_shift($tempPercentError);
        // }
    
        // // menjumlahkan nilai mutlak error
        // $tempPer = array_sum($tempPercentError);
        // $count = count($tempPercentError)-1;
        // $MAPE = round($tempPer / $count, 2);
    
        // return array(
        //   'percent' => $percentError,
        //   'MAPE' => $MAPE
        // );
    
        for ($i = $ma; $i < $index; $i++) { 
          $percentError[$i] = round($absError[$i] / $data[$i][1] * 100 , 2);
        }
            
        $tempPercentError = array_slice($percentError, $ma);
        $MAPE = round(array_sum($tempPercentError) / (count($tempPercentError) - 1), 2);
        
        return array('percent' => $percentError, 'MAPE' => $MAPE);
      }
    
      public function label_now() {
        // $tanggal = new \DateTime('now');
        // $bulan = $this->intToMonth($tanggal->format('m') - 1);
        // $tahun = $tanggal->format('Y');
        // dd($tahun);
    
        // return $bulan.' ('.$tahun.')';
        // \Carbon\Carbon::setLocale('id');
        // $month = Income::latest()->first()->month;
        // $year = Income::latest()->first()->year;
        // $monthNumber = Carbon::parse($month)->format('m');
        // $date = Carbon::createFromDate($year, $monthNumber, null, 0);
    
        // setlocale(LC_TIME, 'id_ID');
      
        // $nextMonth = $date->addMonth()->isoFormat('MMMM (Y)');
        
        
        // return $nextMonth;
        \Carbon\Carbon::setLocale('id');
        $bulan = Income::orderBy('date', 'DESC')->first()->date;
        $dateParse = Carbon::parse($bulan);
        $bulanDepan = $dateParse->addMonth()->isoFormat('MMMM (Y)');

        return $bulanDepan;
      }
}
