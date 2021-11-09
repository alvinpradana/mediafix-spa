<?php

namespace App\Imports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\ToModel;

class EquipmentsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Equipment([
            'user_id' => auth()->user()->id,
            'equipment_type' => $row[0],
            'equipment_name' => $row[1],
            'equipment_quantity' => $row[2],
            'equipment_condition' => $row[3],
        ]);
    }
}
