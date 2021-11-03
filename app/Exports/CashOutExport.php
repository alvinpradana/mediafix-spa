<?php

namespace App\Exports;

use App\Models\CashOut;
use Maatwebsite\Excel\Concerns\FromCollection;

class CashOutExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CashOut::get([
            'cash_date',
            'cash_description',
            'cash_amount',
        ]);
    }
}
