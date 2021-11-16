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
    public function index(Request $request)
    {
        $user = auth()->user()->id;
        $count = Sparepart::where('spareparts.user_id', '=', auth()->user()->id)->sum('sparepart_quantity');
        $spareparts = Sparepart::query()
            ->when($request['search'], function ($query, $search) {
                $query->where('sparepart_type', 'like', '%' . $search . '%')
                    ->orWhere('sparepart_name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->where('spareparts.user_id', '=', auth()->user()->id)
            ->paginate(6)
            ->withQueryString();
        
        return Inertia::render('Spareparts/Index', [
            'spareparts' => $spareparts,
            'count' => $count,
            'user' => $user,
            'filters' => $request->only(['search'])
        ]);
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
