<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('units')
            ->latest()
            ->limit(8)
            ->get();

        return Inertia::render('Invoices/Index', compact('invoices'));
    }

    public function create()
    {
        $code = Invoice::orderBy('id', 'desc')->pluck('id')->first();
        if($code == null || $code == ""){
            $code = 1;
        } else {
            $code = $code + 1;
        }
        $invoice_code = 'INV/' . date('Ymd/') . 'MF/' . (str_pad($code, 3, '0', STR_PAD_LEFT));

        return Inertia::render('Invoices/CreateInvoice', compact('invoice_code'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_code' => ['required'],
            'customer_name' => ['required'],
            'customer_phone' => ['required', 'max:20'],
            'date_in' => ['required', 'date'],
            'date_taken' => ['nullable', 'date'],
            'guarantee' => ['nullable'],
            'order_status' => ['required'],
            'payment_status' => ['required'],
            'discount' => ['nullable'],
            'down_payment' => 'nullable',
            'notes' => ['nullable'],
            'units.*.unit_quantity' => ['required', 'integer', 'min:1'],
            'units.*.unit_type' => ['required'],
            'units.*.unit_name' => ['required'],
            'units.*.unit_description' => ['required'],
            'units.*.unit_completeness' => ['required'],
            'units.*.unit_cost' => ['nullable'],
        ]);

        $units = collect($request->units)->transform(function($unit) {
            $unit['total_cost'] = $unit['unit_quantity'] * $unit['unit_cost'];
            return new Unit($unit);
        });

        if ($units->isEmpty()) {
            return Redirect::back()->with('alert_error', 'One or more unit is required!');
        }

        $data = $request->except('units');
        $data['subtotal'] = $units->sum('total_cost');

        $discAmount = $data['subtotal'] * ($data['discount'] / 100);
        $data['total_payment'] = $data['subtotal'] - $discAmount;
        $data['dependents'] = $data['total_payment'] - $data['down_payment'];

        $code = Invoice::orderBy('id', 'desc')->pluck('id')->first();
        if($code == null || $code == ""){
            $code = 1;
        } else {
            $code = $code + 1;
        }

        $invoice_code = 'INV/' . date('Ymd/') . 'MF/' . (str_pad($code, 3, '0', STR_PAD_LEFT));
        $data['invoice_code'] = $invoice_code;

        $invoice = Invoice::create($data);

        $invoice->units()->saveMany($units);
        return Redirect::route('invoices.index')->with('alert_success', 'Invoice created successfully');
    }

    public function edit($id)
    {
        $invoice = Invoice::with('units')->findOrFail($id);
        return Inertia::render('Invoices/EditInvoice', compact('invoice'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_code' => ['required'],
            'customer_name' => ['required'],
            'customer_phone' => ['required', 'max:20'],
            'date_in' => ['required', 'date'],
            'date_taken' => ['nullable', 'date'],
            'guarantee' => ['nullable'],
            'order_status' => ['required'],
            'payment_status' => ['required'],
            'discount' => ['nullable'],
            'down_payment' => ['nullable'],
            'notes' => ['nullable'],
            'units.*.unit_quantity' => ['required', 'integer', 'min:1'],
            'units.*.unit_type' => ['required'],
            'units.*.unit_name' => ['required'],
            'units.*.unit_description' => ['required'],
            'units.*.unit_completeness' => ['required'],
            'units.*.unit_cost' => ['nullable', 'numeric'],
        ]);

        $invoice = Invoice::findOrFail($id);

        $units = collect($request->units)->transform(function($unit) {
            $unit['total_cost'] = $unit['unit_quantity'] * $unit['unit_cost'];
            return new Unit($unit);
        });

        if ($units->isEmpty()) {
            return Redirect::back()->with('alert_error', 'One or more unit is required!');
        }

        $data = $request->except('units');
        $data['subtotal'] = $units->sum('total_cost');

        $discAmount = $data['subtotal'] * ($data['discount'] / 100);
        $data['total_payment'] = $data['subtotal'] - $discAmount;
        $data['dependents'] = $data['total_payment'] - $data['down_payment'];

        $invoice->update($data);

        Unit::where('invoice_id', $invoice->id)->delete();

        $invoice->units()->saveMany($units);

        return Redirect::route('invoices.index')->with('alert_success', 'Invoice updated successfully');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return Redirect::back()->with('alert_success', 'Invoice deleted successfully');
    }
}
