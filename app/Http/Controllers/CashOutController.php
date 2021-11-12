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
        $cash_out = CashOut::latest()->where('cash_outs.user_id', '=', auth()->user()->id)->paginate(6);

        $month = date('m');
        $year = date('Y');
        $user = auth()->user()->id;

        $total_amount = CashOut::whereYear('cash_date', $year)
            ->whereMonth('cash_date', $month)
            ->where('cash_outs.user_id', '=', auth()->user()->id)
            ->sum('cash_amount');

        return Inertia::render('Cash/Index', compact('cash_out', 'total_amount', 'user'));
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'user_id' => ['required'],
            'cash_description' => ['required'],
            'cash_date' => ['required', 'date'],
            'cash_amount' => ['required', 'numeric'],
        ]);

        CashOut::create($attr);
        return Redirect::back()->with('alert_success', 'Cashes has been created.');
    }

    public function edit($id)
    {
        $cash_out = CashOut::where('cash_outs.user_id', '=', auth()->user()->id)->findOrFail($id);
        return Inertia::render('Cash/CashOut', compact('cash_out'));
    }

    public function update(Request $request, $id)
    {
        $attr = $request->validate([
            'cash_description' => ['required'],
            'cash_date' => ['required', 'date'],
            'cash_amount' => ['required', 'numeric'],
        ]);
        CashOut::where('id', $id)->update($attr);
        return Redirect::back()->with('Cashes has been updated.');
    }

    public function destroy($id)
    {
        CashOut::where('cash_outs.user_id', '=', auth()->user()->id)->findOrFail($id)->delete();
        return Redirect::back()->with('alert_success', 'Cashes has been deleted.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,xls,xlsx', 'max:2048']
        ]);

        Excel::import(new CashOutImport, request()->file('file'));
        return Redirect::back()->with('alert_success', 'Cashes has been imported.');
    }

    public function export()
    {
        return Excel::download(new CashOutExport, 'Cash-Out-'. date('Y-m-d') .'.xlsx');
    }
}
