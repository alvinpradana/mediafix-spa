<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function index()
    {
        return view('web.homepage');
    }

    public function invoice(Request $request)
    {
        $invoices = Invoice::with('units')->where('stripe_token', '=', $request->stripe_token)->get();
        return view('web.invoice', compact('invoices'));
    }
}
