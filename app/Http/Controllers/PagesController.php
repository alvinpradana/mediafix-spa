<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Invoice;
use App\Models\Sparepart;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        $invoices = Invoice::with('units')
            ->latest()
            ->limit(5)
            ->get();
            
        $sparepart = Sparepart::count();
        $equipment = Equipment::count();

        return Inertia::render('Home', compact('invoices', 'sparepart', 'equipment'));
    }

    public function report()
    {
        return Inertia::render('Report/Index');
    }
}
