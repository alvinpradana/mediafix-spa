<?php

namespace App\Exports;

use App\Models\Sparepart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SparepartsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'TYPE',
            'NAME',
            'QUANTITY',
            'PRICE',
        ];
    }
    public function collection()
    {
        return Sparepart::get([
            'sparepart_type',
            'sparepart_name',
            'sparepart_quantity',
            'sparepart_price',
        ]);
    }
}
