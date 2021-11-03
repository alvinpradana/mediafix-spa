<?php

namespace App\Exports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\FromCollection;

class EquipmentsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Equipment::get([
            'equipment_type',
            'equipment_name',
            'equipment_quantity',
            'equipment_condition',
        ]);
    }
}
