<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Invoice;
use App\Models\Equipment;
use App\Models\Sparepart;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $invoices = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->latest()->paginate(5);
            
        $sparepart = Sparepart::count();
        $equipment = Equipment::count();

        return Inertia::render('Dashboard/Dashboard', compact('invoices', 'sparepart', 'equipment'));
    }
}
