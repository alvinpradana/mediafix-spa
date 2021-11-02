<?php

namespace App\Imports;

use App\Models\Sparepart;
use Maatwebsite\Excel\Concerns\ToModel;

class SparepartsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Sparepart([
            'sparepart_type' => $row[0],
            'sparepart_name' => $row[1],
            'sparepart_quantity' => $row[2],
            'sparepart_price' => $row[3],
        ]);
    }
}
