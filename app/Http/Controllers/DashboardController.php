<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Invoice;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $invoices = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->latest()->paginate(5);

        return Inertia::render('Dashboard/Dashboard', compact('invoices'));
    }
}
