<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoicesController extends Controller
{
    public function index()
    {
        return Inertia::render('Invoices/CreateInvoice');
    }

    public function create()
    {
        $code = Invoice::orderBy('id', 'desc')->pluck('id')->first();
        if($code == null || $code == ""){
            $code = 1;
        } else {
            $code = $code + 1;
        }
        $invoice_code = 'MF-' . (str_pad($code, 4, '0', STR_PAD_LEFT));

        return Inertia::render('Invoices/CreateInvoice', compact('invoice_code'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_code' => ['required'],
            'customer_name' => ['required'],
            'customer_phone' => ['required'],
            'date_in' => ['required'],
            'date_taken' => ['nullable'],
            'order_status' => ['required'],
            'payment_status' => ['required'],
            'subtotal' => ['required'],
            'discount' => ['nullable'],
            'total_payment' => ['required'],
            'down_payment' => ['nullable'],
            'dependents' => ['required'],
            'notes' => ['nullable'],
            'units.*.invoices_id' => ['required'],
            'units.*.unit_quantity' => ['required|integer|min:1'],
            'units.*.unit_type' => ['required'],
            'units.*.unit_name' => ['required'],
            'units.*.unit_description' => ['required'],
            'units.*.unit_completeness' => ['required'],
            'units.*.unit_cost' => ['required|numeric'],
            'units.*.total_cost' => ['required']
        ]);

        $units = collect($request->units)->transform(function($unit) {
            $unit['total_cost'] = $unit['unit_quantity'] * $unit['unit_cost'];

            Unit::create($unit);
        });
    }
}
