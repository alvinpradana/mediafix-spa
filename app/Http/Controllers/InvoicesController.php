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
            ->orderBy('created_at', 'desc')
            ->limit(5)
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
        $invoice_code = 'MF-' . (str_pad($code, 4, '0', STR_PAD_LEFT));

        return Inertia::render('Invoices/CreateInvoice', compact('invoice_code'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'invoice_code' => ['required'],
            'customer_name' => ['required'],
            'customer_phone' => ['required', 'max:15'],
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
            return response()->json([
                'units_empty' => ['One or more item is required!.']
            ], 422);

            // return Redirect::back()->with('error', 'One or more item is required!');

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
        $invoice_code = 'MF-' . (str_pad($code, 4, '0', STR_PAD_LEFT));
        $data['invoice_code'] = $invoice_code;

        $invoice = Invoice::create($data);

        $invoice->units()->saveMany($units);

        return Redirect::route('invoices.index')->with('message', 'Invoice created successfully');
    }

    public function edit($id)
    {
        $invoice = Invoice::with('units')->findOrFail($id);

        // return response()->json([
        //     'invoice' => $invoice,
        // ]);

        return Inertia::render('Invoices/EditInvoice', compact('invoice'));
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return Redirect::back()->with('message', 'Invoice deleted successfully');
    }
}
