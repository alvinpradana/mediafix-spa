<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class EquipmentsController extends Controller
{
    public function index()
    {
        $count = Equipment::sum('equipment_quantity');
        $equipments = Equipment::latest()
            ->limit(6)
            ->get();
        return Inertia::render('Equipments/Index', compact('equipments', 'count'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_type' => ['required'],
            'equipment_name' => ['required'],
            'equipment_quantity' => ['required', 'numeric'],
            'equipment_condition' => ['required'],
        ]);
        Equipment::create($request->all());
        return Redirect::route('equipments.index');
    }

    public function edit($id)
    {
        $equipment = Equipment::find('id');
        return Inertia::render(route('equipments.index'), compact('equipment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'equipment_type' => ['required'],
            'equipment_name' => ['required'],
            'equipment_quantity' => ['required', 'numeric'],
            'equipment_condition' => ['required'],
        ]);
        Equipment::where('id', $id)->update($request->only([
            'equipment_type',
            'equipment_name',
            'equipment_quantity',
            'equipment_condition',
        ]));
        return Redirect::back();
    }

    public function destroy($id)
    {
        Equipment::findOrFail($id)->delete();
        return Redirect::back();
    }
}
