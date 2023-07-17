<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = $this->monthlyIncome();
        return view('income.index', [
            'incomes' => $incomes
        ]);
    }

    public function monthlyIncome() {
        $data = Income::select([
            DB::raw('sum(income) as total'),
            DB::raw('EXTRACT(MONTH from date) as month'),
            DB::raw('EXTRACT(YEAR from date) as year')
        ])
        ->groupBy('month', 'year')
        ->orderByDesc('year')
        ->orderByDesc('month')
        ->paginate(5)
        ->withQueryString();

        return $data;
    }

    public function dailyIncome($bulan, $tahun) {
        $tanggal = \Carbon\Carbon::createFromFormat('m-Y', $bulan.'-'.$tahun);
        $pendapatanHarian = Income::whereYear('date', $tahun)
                        ->whereMonth('date', $bulan)
                        ->orderBy('date')
                        ->get()
                        ->toArray();

        return view('income.detail', [
            'dailyIncomes' => $pendapatanHarian,
            'tanggal' => $tanggal
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('income.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'date' => ['required','max:255','unique:'.Income::class],
            'income' => ['required']
        ]);

        $validateData['user_id'] = auth()->user()->id;

        Income::create($validateData);
        return redirect('/income');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $date = substr($id, 0, -4);
        $year = substr($id, -4);

        $tanggal = \Carbon\Carbon::createFromFormat('m-Y', $date.'-'.$year)->locale('id')->isoFormat('MMMM YYYY');
        $pendapatanHarian = Income::whereYear('date', $year)
                        ->whereMonth('date', $date)
                        ->orderBy('date')
                        ->paginate(7);

        return view('income.show', [
            'dailyIncomes' => $pendapatanHarian,
            'tanggal' => $tanggal
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        return view('income.edit', [
            'income' => $income
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $validateData = $request->validate([
            'date' => 'required|max:255',
            'income' => 'required'
        ]);

        $validateData['user_id'] = auth()->user()->id;
        Income::where('id', $income->id)->update($validateData);
        return redirect('/income');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Income $income)
    {
        Income::destroy($income->id);
        return redirect('/income');
    }
}
