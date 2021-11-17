<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Unit;
use Inertia\Inertia;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;

class InvoicesController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::query()
            ->where('invoices.user_id', '=', auth()->user()->id)
            ->when($request['search'], function ($query, $search) {
                $query->where('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('invoice_code', 'like', '%' . $search . '%')
                    ->where('invoices.user_id', '=', auth()->user()->id)
                    ->orWhere('payment_status', 'like', '%' . $search . '%')
                    ->where('invoices.user_id', '=', auth()->user()->id)
                    ->orWhere('order_status', 'like', '%' . $search . '%');
                })
            ->with('units')
            ->latest()
            ->where('invoices.user_id', '=', auth()->user()->id)
            ->paginate(6)
            ->onEachSide(1)
            ->withQueryString();

        return Inertia::render('Invoices/Index', [
            'invoices' => $invoices,
            'filters' => $request->only(['search'])
        ]);
    }

    public function show($id)
    {
        $invoice = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->findOrFail($id);
        $user = auth()->user();
        $date_in = Carbon::parse($invoice->date_in)->format('d M Y');
        $date_taken = $invoice->date_taken;

        if ($date_taken == null) {
            $date_taken = '-';
        } else {
            $date_taken = Carbon::parse($invoice->date_taken)->format('d M Y');
        }

        foreach ($invoice->units as $unit) {
            $description[] = $unit->unit_type . ' : ' . $unit->unit_description;
            $completeness[] = $unit->unit_type . ' : ' . $unit->unit_completeness;
            $qty_name[] = strtoupper($unit->unit_quantity). ' x ' . strtoupper($unit->unit_type) . ' ' . strtoupper($unit->unit_name);
            
            if ($unit->unit_cost == 0) {
                $qty_cost[] = strtoupper($unit->unit_type) . ' : ' . '-';
            } else {
                $qty_cost[] = strtoupper($unit->unit_type) . ' : ' . $unit->unit_quantity. ' x Rp. ' . $unit->unit_cost;
            }
        }

        $unit_info = implode('*%0a*', $qty_name);
        $cost_info = implode('*%0a*', $qty_cost);
        $unit_desc = implode('*%0a*', $description);
        $unit_comp = implode('*%0a*', $completeness);

        $subtotal = $invoice->subtotal;
        if ($subtotal == 0) {
            $subtotal = '-';
        } else {
            $subtotal = $invoice->subtotal;
        }

        $total_payment = $invoice->total_payment;
        if($total_payment == 0) {
            $total_payment = '-';
        } else {
            $total_payment = $invoice->total_payment;
        }

        $down_payment = $invoice->down_payment;
        if($down_payment == 0) {
            $down_payment = '-';
        } else {
            $down_payment = $invoice->down_payment;
        }

        $guarantee = $invoice->guarantee;
        if($guarantee == 0) {
            $guarantee = '-';
        } else {
            $guarantee = '*' . $invoice->guarantee . ' Hari*';
        }

        $discount = $invoice->discount;
        if($discount == 0) {
            $discount = '';
        } else {
            $discount = 'Discount : ' . '*'.$invoice->discount.' %*' . '%0a%0a';
        }

        $link = '62' . $invoice->customer_phone 
            . '?text=*INVOICE INFORMATION*%0a%0aKami dari *MEDIA FIX* '
            . 'menginformasikan kepada pelanggan kami dengan keterangan sebagai berikut :%0a%0a'

            . 'No. Nota : '
            . '*'.$invoice->invoice_code.'*' . '%0a'

            . 'Nama Customer : '
            . '*'.strtoupper($invoice->customer_name).'*' . '%0a%0a'

            . 'Tanggal Masuk : ' . '*'.$date_in.'*' . '%0a'
            . 'Pengambilan : ' . '*'.$date_taken.'*' . '%0a%0a'
            
            . 'Unit Repair :%0a'
            . '*' . $unit_info . '*' . '%0a%0a'

            . 'Keterangan :%0a'
            . '*'.strtoupper($unit_desc).'*' . '%0a%0a'

            . 'Kelengkapan :%0a'
            . '*'.strtoupper($unit_comp).'*' . '%0a%0a'

            . 'Biaya :%0a'
            . '*'.$cost_info. '*' . '%0a%0a'

            . 'Subtotal : '
            . '*Rp. '. $subtotal .'*' . '%0a%0a'

            . $discount

            . 'Total Biaya : '
            . '*Rp. '.$total_payment.'*' . '%0a%0a'

            . 'DP / Jumlah Bayar : '
            . '*Rp. '.$down_payment.'*' . '%0a%0a'

            . 'Keterangan :%0a'
            . 'Status order : ' . '*'.strtoupper($invoice->order_status).'*' . '%0a'
            . 'Status Pembayaran : ' . '*'.strtoupper($invoice->payment_status).'*%0a%0a' 

            . 'Tunggakan : '
            . '*Rp. '.$invoice->dependents.'*' . '%0a%0a'

            . 'Garansi : '
            . $guarantee . '%0a%0a'

            . 'Token : '
            . '*'.$invoice->stripe_token.'*' . '%0a%0a'
            
            . '_Notes :_%0a'
            . '_Harap bisa menunjukkan pesan ini untuk pengambilan unit servis, dan atau dengan nota cetak yang diberikan oleh kasir._%0a%0a'
            . '_Terima Kasih._%0a%0a'

            . '_Contact Us :_%0a'
            . 'WA / Phone : ' . auth()->user()->phone . '%0a'
            . 'Instagram : @mediafix.id | @mediafix.jogja%0a'
            . 'Website : www.mediafix.id%0a'
        ;
        return Inertia::render('Invoices/ShowInvoice', compact('invoice', 'link', 'date_in', 'date_taken'));
    }

    public function print($id)
    {
        $invoices = Invoice::with('units')->where('invoices.user_id', '=', auth()->user()->id)->findOrFail($id);
        $date_in = Carbon::parse($invoices->date_in)->format('d M Y');
        $date_taken = $invoices->date_taken;

        if ($date_taken == null) {
            $date_taken = '-';
        } else {
            $date_taken = Carbon::parse($invoices->date_taken)->format('d M Y');
        }

        return view('print', compact('invoices', 'date_in', 'date_taken'));
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

        $stripe_token = strtoupper(Str::random(8));

        $user = auth()->user()->id;

        return Inertia::render('Invoices/CreateInvoice', compact('invoice_code', 'user', 'stripe_token'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required'],
            'stripe_token' => ['required'],
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
