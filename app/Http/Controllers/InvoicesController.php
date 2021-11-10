<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\Invoice;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class InvoicesController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->latest()->paginate(6);

        return Inertia::render('Invoices/Index', compact('invoices'));
    }

    public function show($id)
    {
        $invoice = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->findOrFail($id);
        return Inertia::render('Invoices/ShowInvoice', compact('invoice'));
    }

    public function print($id)
    {
        $invoices = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->findOrFail($id);
        return view('print', compact('invoices'));
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

        $user = auth()->user()->id;

        return Inertia::render('Invoices/CreateInvoice', compact('invoice_code', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required'],
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
        return Redirect::route('invoice.index')->with('alert_success', 'Invoice created successfully.');
    }

    public function edit($id)
    {
        $invoice = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->findOrFail($id);
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

        $invoice = Invoice::where('invoices.user_id', '=', auth()->user()->id)->findOrFail($id);

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

        return Redirect::route('invoice.index')->with('alert_success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        Invoice::where('invoices.user_id', '=', auth()->user()->id)->findOrFail($id)->delete();

        return Redirect::route('invoice.index')->with('alert_success', 'Invoice deleted successfully.');
    }

    public function mark(Request $request, $id)
    {
        $request->validate([
            'mark' => ['required']
        ]);

        Invoice::where('id', $id)->update($request->only('mark'));
        return Redirect::route('invoice.index')->with('alert_success', 'The order has been taken successfully.');
    }

    public function export()
    {
        return Excel::download(new InvoicesExport, 'Invoice-'. date('Y-m-d') .'.xlsx');
    }
}
