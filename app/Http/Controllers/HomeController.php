<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Invoice;
use App\Models\Sparepart;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function dashboard()
    {
        $invoices = Invoice::with('units')->latest()->paginate(5);
            
        $sparepart = Sparepart::count();
        $equipment = Equipment::count();

        return Inertia::render('Home', compact('invoices', 'sparepart', 'equipment'));
    }

    public function users()
    {
        return Inertia::render('Users/Index');
    }
}
