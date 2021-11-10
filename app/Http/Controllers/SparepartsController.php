<?php

namespace App\Http\Controllers;

use App\Exports\SparepartsExport;
use App\Imports\SparepartsImport;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SparepartsController extends Controller
{
    public function index()
    {
        $user = auth()->user()->id;
        $count = Sparepart::sum('sparepart_quantity');
        $spareparts = Sparepart::latest()->where('spareparts.user_id', '=', auth()->user()->id)->paginate(6);
        
        return Inertia::render('Spareparts/Index', compact('spareparts', 'count', 'user'));
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'user_id' => ['required'],
            'sparepart_type' => ['required'],
            'sparepart_name' => ['required'],
            'sparepart_quantity' => ['required', 'numeric'],
            'sparepart_price' => ['nullable', 'numeric'],
        ]);

        Sparepart::create($attr);
        return Redirect::back()->with('alert_success', 'Sparepart has been added successfully.');
    }

    public function edit($id)
    {
        $sparepart = Sparepart::where('spareparts.user_id', '=', auth()->user()->id)->findOrFail($id);
        return Inertia::render('Spareparts/Index', compact('sparepart'));
    }

    public function update(Request $request, $id)
    {
        $attr = $request->validate([
            'sparepart_type' => ['required'],
            'sparepart_name' => ['required'],
            'sparepart_quantity' => ['required', 'numeric'],
            'sparepart_price' => ['nullable', 'numeric'],
        ]);

        Sparepart::where('id', $id)->update($attr);
        return Redirect::back()->with('alert_success', 'Sparepart updated successfully.');
    }

    public function destroy($id)
    {
        Sparepart::where('spareparts.user_id', '=', auth()->user()->id)->findOrFail($id)->delete();
        return Redirect::back()->with('alert_success', 'Sparepart deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,xlx,xlsx', 'max:2048']
        ]);

        Excel::import(new SparepartsImport, request()->file('file'));
        return Redirect::back()->with('alert_success', 'Sparepart imported successfully.');
    }

    public function export()
    {
        return Excel::download(new SparepartsExport, 'Sparepart-' . date('Y-m-d') . '.xlsx');
    }
}
