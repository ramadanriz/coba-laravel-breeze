<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
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

      array_push($label, $nextPeriod);
    
      foreach ($hasil['MA'] as $value) {
        array_push($data2,$value);
      }
    }

    
    $data1LastTwelve = array_splice($data1, -12);
    array_push($data1LastTwelve, null);
    // $data2LastTwelve = array_splice($data2, -13);

    return view('forecasting.index', [
      "hasil" => isset($_POST['generate']) ? $hasil : '',
      "index" => $index,
      "label" => isset($_POST['generate']) ? $label : '',
      // "labelTwelve" => isset($_POST['generate']) ? $labelLastTwelve : '',
      "data1" => isset($_POST['generate']) ? $data1 : '',
      "data1Twelve" => isset($_POST['generate']) ? $data1LastTwelve : '',
      "data2" => isset($_POST['generate']) ? $data2 : '',
      // "data2Twelve" => isset($_POST['generate']) ? $data2LastTwelve : '',
      "nextPeriod" => isset($_POST['generate']) ? $nextPeriod : ''
    ]);
  }
    
  public function getData() {
    $data = Income::select([
      DB::raw('sum(income) as total'),
      DB::raw('EXTRACT(MONTH from date) as month'),
      DB::raw('EXTRACT(YEAR from date) as year')
    ])
    ->groupBy('month', 'year')
    ->orderBy('date')
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
    $MA = array_fill(0, $index + 1, NULL);
    for ($i = $ma - 1; $i < $index; $i++) { 
        $MA[$i+1] = round(array_sum(array_column(array_slice($data, $i - $ma + 1, $ma), 1)) / $ma);
    }
    return $MA;
  }
    
  public function MFE($data,$index,$ma,$MA) {
    $error = array_fill(0, $index + 1, NULL);

    for ($i = $ma; $i < $index; $i++) { 
      $error[$i] = $data[$i][1] - $MA[$i];
    }

    $tempError = array_slice($error, $ma);
    $MFE = round(array_sum($tempError) / (count($tempError) - 1), 2);

    return array('error' => $error, 'MFE' => $MFE);
  }
    
  public function MAD($error,$index,$ma) {
    $absError = array_fill(0, $index + 1, NULL);

    for ($i = $ma; $i < $index; $i++) { 
        $absError[$i] = abs($error[$i]);
    }
    
    $tempAbsError = array_slice($absError, $ma);
    $MAD = round(array_sum($tempAbsError) / (count($tempAbsError) - 1), 2);

    return array('absError' => $absError, 'MAD' => $MAD);
  }
    
  public function MSE($absError,$index,$ma) {
    $powError = array_fill(0,$index + 1,NULL);

    for ($i = $ma; $i < $index; $i++) { 
      $powError[$i] = pow($absError[$i], 2);
    }
        
    $tempPowError = array_slice($powError, $ma);
    $MSE = round(array_sum($tempPowError) / (count($tempPowError) - 1), 2);
    
    return array('powError' => $powError, 'MSE' => $MSE);
  }
    
  public function MAPE($data,$absError,$index,$ma) {
    $percentError = array_fill(0,$index + 1,NULL);

    for ($i = $ma; $i < $index; $i++) { 
      $percentError[$i] = round($absError[$i] / $data[$i][1] * 100 , 2);
    }
        
    $tempPercentError = array_slice($percentError, $ma);
    $MAPE = round(array_sum($tempPercentError) / (count($tempPercentError) - 1), 2);
    
    return array('percent' => $percentError, 'MAPE' => $MAPE);
  }
    
  public function label_now() {
    \Carbon\Carbon::setLocale('id');
    $bulan = Income::orderBy('date', 'DESC')->first()->date;
    $dateParse = Carbon::parse($bulan);
    $bulanDepan = $dateParse->addMonth()->isoFormat('MMMM (Y)');

    return $bulanDepan;
  }
}
