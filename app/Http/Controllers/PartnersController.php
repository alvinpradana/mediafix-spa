<?php

namespace App\Http\Controllers;

use App\Exports\PartnersExport;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = Partner::latest()->where('partners.user_id', '=', auth()->user()->id)->paginate(6);
        return Inertia::render('Partners/Partners', compact('partners'));
    }

    public function create()
    {
        $user = auth()->user()->id;
        return Inertia::render('Partners/CreatePartner', compact('user'));
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'user_id' => ['required'],
            'partner_name' => ['required'],
            'phone_number' => ['required'],
            'partner_email' => ['required', 'email'],
            'start_join' => ['required', 'date'],
            'partner_company' => ['required'],
            'partner_address' => ['required'],
        ]);

        Partner::create($attr);
        return Redirect::route('partners.index')->with('alert_success', 'Partner has been added successfully.');
    }

    public function edit($id)
    {
        $partner = Partner::where('partners.user_id', '=', auth()->user()->id)->findOrFail($id);
        return Inertia::render('Partners/EditPartner', compact('partner'));
    }

    public function update(Request $request, $id)
    {
        $attr = $request->validate([
            'partner_name' => ['required'],
            'phone_number' => ['required'],
            'partner_email' => ['required', 'email'],
            'start_join' => ['required', 'date'],
            'partner_company' => ['required'],
            'partner_address' => ['required'],
        ]);

        Partner::where('id', $id)->update($attr);
        return Redirect::route('partners.index')->with('alert_success', 'Partner updated successfully.');
    }

    public function destroy($id)
    {
        Partner::where('partners.user_id', '=', auth()->user()->id)->findOrFail($id)->delete();        
        return Redirect::back()->with('alert_success', 'Partner deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new PartnersExport, 'Partner-'. date('Y-m-d') .'.xlsx');
    }
}
