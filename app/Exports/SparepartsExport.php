<?php

namespace App\Exports;

use App\Models\Sparepart;
use Maatwebsite\Excel\Concerns\FromCollection;

class SparepartsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
