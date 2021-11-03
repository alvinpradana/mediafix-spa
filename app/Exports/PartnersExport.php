<?php

namespace App\Exports;

use App\Models\Partner;
use Maatwebsite\Excel\Concerns\FromCollection;

class PartnersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Partner::get([
            'partner_name',
            'phone_number',
            'partner_email',
            'start_join',
            'partner_company',
            'partner_address',
        ]);
    }
}
