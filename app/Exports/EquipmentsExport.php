<?php

namespace App\Exports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EquipmentsExport implements FromCollection, WithHeadings
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
            'CONDITION',
        ];
    }
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
