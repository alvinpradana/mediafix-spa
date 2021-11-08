<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoicesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'INVOICE CODE',
            'CUSTOMER',
            'TELEPON/WA',
            'TANGGAL MASUK',
            'PENGAMBILAN',
            'GARANSI',
            'STATUS ORDER',
            'STATUS PEMBAYARAN',
            'DISCOUNT',
            'UANG MUKA',
            'TOTAL BAYAR',
            'CATATAN',
            'UNIT',
            'TIPE',
            'KETERANGAN',
            'KELENGKAPAN',
            'BIAYA',
            'TOTAL BIAYA',
        ];
    }
    public function collection()
    {
        $invoice = Invoice::join('units', 'units.invoice_id', '=', 'invoices.id')
            ->where('invoices.user_id', '=', auth()->user()->id)
            ->select([
                'invoice_code',
                'customer_name',
                'customer_phone',
                'date_in',
                'date_taken',
                'guarantee',
                'order_status',
                'payment_status',
                'discount',
                'down_payment',
                'total_payment',
                'notes',
                'unit_type',
                'unit_name',
                'unit_description',
                'unit_completeness',
                'unit_cost',
                'total_cost',
            ])->get();

        return $invoice;
    }
}
