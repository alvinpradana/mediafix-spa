<?php

namespace App\Http\Controllers;

use App\Exports\EquipmentsExport;
use App\Imports\EquipmentsImport;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class EquipmentsController extends Controller
{
    public function index()
    {
        $count = Equipment::sum('equipment_quantity');
        $equipments = Equipment::latest()->where('equipments.user_id', '=', auth()->user()->id)->paginate(6);
        $user = auth()->user()->id;

        return Inertia::render('Equipments/Index', compact('equipments', 'count', 'user'));
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'user_id' => ['required'],
            'equipment_type' => ['required'],
            'equipment_name' => ['required'],
            'equipment_quantity' => ['required', 'numeric'],
            'equipment_condition' => ['required'],
        ]);

        Equipment::create($attr);
        return Redirect::back()->with('alert_success', 'Equipment has been added successfully.');
    }

    public function edit($id)
    {
        $equipment = Equipment::where('equipments.user_id', '=', auth()->user()->id)->findOrFail($id);
        return Inertia::render('Equipments/Index', compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $attr = $request->validate([
            'equipment_type' => ['required'],
            'equipment_name' => ['required'],
            'equipment_quantity' => ['required', 'numeric'],
            'equipment_condition' => ['required'],
        ]);

        Equipment::where('id', $id)->update($attr);
        return Redirect::back()->with('alert_success', 'Equipment updated successfully.');
    }

    public function destroy($id)
    {
        Equipment::where('equipments.user_id', '=', auth()->user()->id)->findOrFail($id)->delete();
        return Redirect::back()->with('alert_success', 'Equipment deleted successfully.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:csv,xlx,xlsx', 'max:2048']
        ]);

        Excel::import(new EquipmentsImport, request()->file('file'));
        return Redirect::back()->with('alert_success', 'Equipment imported successfully.');
    }

    public function export()
    {
        return Excel::download(new EquipmentsExport, 'Equipment-'. date('Y-m-d') .'.xlsx');
    }
}
