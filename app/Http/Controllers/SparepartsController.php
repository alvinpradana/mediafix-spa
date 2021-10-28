<?php

namespace App\Http\Controllers;

use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SparepartsController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::orderBy('id', 'desc')->limit(6)->get(); 
        return Inertia::render('Spareparts/Index', compact('spareparts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sparepart_type' => ['required'],
            'sparepart_name' => ['required'],
            'sparepart_quantity' => ['required', 'numeric'],
            'sparepart_price' => ['nullable', 'numeric'],
        ]);
        Sparepart::create($request->all());
        return Redirect::route('spareparts.index');
    }

    public function edit($id)
    {
        $sparepart = Sparepart::find('id');
        return Inertia::render('Spareparts/Index', compact('sparepart'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'sparepart_type' => ['required'],
            'sparepart_name' => ['required'],
            'sparepart_quantity' => ['required', 'numeric'],
            'sparepart_price' => ['nullable', 'numeric'],
        ]);
        Sparepart::where('id', $id)->update($request->only([
            'sparepart_type',
            'sparepart_name',
            'sparepart_quantity',
            'sparepart_price',
        ]));
        return Redirect::back();
    }

    public function destroy($id)
    {
        Sparepart::findOrFail($id)->delete();
        return Redirect::back();
    }
}
