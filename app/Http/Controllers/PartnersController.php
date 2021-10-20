<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = Partner::orderBy('id', 'desc')->limit(5)->get();
        return Inertia::render('Partners/Partners', compact('partners'));
    }

    public function create()
    {
        return Inertia::render('Partners/CreatePartner');
    }

    public function store(Request $request)
    {
        $request->validate([
            'partner_name' => 'required',
            'phone_number' => 'required',
            'partner_email' => 'required|email',
            'start_join' => 'required',
            'partner_company' => 'required',
            'partner_address' => 'required',
        ]);

        $partner = $request->all();
        Partner::create($partner);
        
        return Redirect::route('partners.index')->with('message', 'Partner added successfully');
    }

    public function edit($id)
    {
        $partner = Partner::find($id);
        return Inertia::render('Partners/EditPartner', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'partner_name' => 'required',
            'phone_number' => 'required',
            'partner_email' => 'required|email',
            'start_join' => 'required',
            'partner_company' => 'required',
            'partner_address' => 'required',
        ]);

        $partner = $request->all();
        Partner::where('id', $id)->update($partner);

        return Redirect::route('partners.index')->with('message', 'Partner updated successfully');
    }

    public function destroy($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->delete();
        
        return Redirect::back()->with('message', 'Partner deleted successfully');
    }
}
