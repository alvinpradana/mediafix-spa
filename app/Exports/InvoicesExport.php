<?php

namespace App\Exports;

use App\Models\Invoice;
use App\Models\Unit;
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
            'PHONE NUMBER',
            'DATE IN',
            'DATE TAKEN',
            'GUARANTEE',
            'ORDER STATUS',
            'PAYMENT STATUS',
            'DISCOUNT',
            'DOWN PAYMENT',
            'TOTAL PAYMENT',
            'NOTES',
        ];
    }
    public function collection()
    {
        $invoice = Invoice::get([
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
        ]);
        $unit = Unit::get([
            'unit_quantity',
            'unit_type',
            'unit_name',
            'unit_description',
            'unit_completeness',
            'unit_cost',
            'total_cost',
        ]);

        return $invoice;
    }
}
