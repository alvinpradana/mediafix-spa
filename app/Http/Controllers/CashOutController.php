<?php

namespace App\Http\Controllers;

use App\Exports\CashOutExport;
use App\Imports\CashOutImport;
use App\Models\CashOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class CashOutController extends Controller
{
    public function index()
    {
        $cash_out = CashOut::latest()->paginate(6);

        $month = date('m');
        $year = date('Y');

        $total_amount = CashOut::whereYear('cash_date', $year)
            ->whereMonth('cash_date', $month)
            ->sum('cash_amount');

        return Inertia::render('Cash/Index', compact('cash_out', 'total_amount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cash_description' => ['required'],
            'cash_date' => ['required', 'date'],
            'cash_amount' => ['required', 'numeric'],
        ]);

        CashOut::create($request->all());
        return Redirect::back();
    }

    public function edit($id)
    {
        $cash_out = CashOut::find('id');
        return Inertia::render('Cash/CashOut', compact('cash_out'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cash_description' => ['required'],
            'cash_date' => ['required', 'date'],
            'cash_amount' => ['required', 'numeric'],
        ]);
        CashOut::where('id', $id)->update($request->only([
            'cash_description',
            'cash_date',
            'cash_amount',
        ]));
        return Redirect::back();
    }

    public function destroy($id)
    {
        CashOut::findOrFail($id)->delete();
        return Redirect::back();
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,xls,xlsx', 'max:2048']
        ]);

        Excel::import(new CashOutImport, request()->file('file'));
        return Redirect::back();
    }

    public function export()
    {
        return Excel::download(new CashOutExport, 'Cash-Out-'. date('Y-m-d') .'.xlsx');
    }
}
