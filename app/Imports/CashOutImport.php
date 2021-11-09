<?php

namespace App\Imports;

use App\Models\CashOut;
use Maatwebsite\Excel\Concerns\ToModel;

class CashOutImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CashOut([
            'user_id' => auth()->user()->id,
            'cash_date' => date('Y-m-d'),
            'cash_description' => $row[0],
            'cash_amount' => $row[1],
        ]);
    }
}
