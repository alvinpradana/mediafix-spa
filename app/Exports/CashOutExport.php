<?php

namespace App\Exports;

use App\Models\CashOut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CashOutExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'DATE',
            'DESCRIPTION',
            'AMOUNT',
        ];
    }
    public function collection()
    {
        return CashOut::get([
            'cash_date',
            'cash_description',
            'cash_amount',
        ]);
    }
}
