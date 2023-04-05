<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('income.index', [
            'incomes' => Income::latest()->filter(request(['search']))->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $months = $this->setMonth();

        return view('income.create', [
            "months" => $months
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'month' => 'required|max:255',
            'year' => 'required|integer|digits:4|max:'.(date('Y')),
            'income' => 'required'
        ]);

        $validateData['user_id'] = auth()->user()->id;

        Income::create($validateData);
        return redirect('/income');
    }

    /**
     * Display the specified resource.
     */
    public function show(Income $income)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Income $income)
    {
        $months = $this->setMonth();
        return view('income.edit', [
            'income' => $income,
            "months" => $months
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Income $income)
    {
        $validateData = $request->validate([
            'month' => 'required|max:255',
            'year' => 'required|integer|digits:4|max:'.(date('Y')),
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

    public function setMonth() {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::createFromDate(null, $i, null, 0);
            $monthName = $month->getTranslatedMonthName();
            array_push($months, $monthName);
        }

        return $months;
    }
}
