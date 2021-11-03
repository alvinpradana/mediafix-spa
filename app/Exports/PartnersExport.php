<?php

namespace App\Exports;

use App\Models\Partner;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PartnersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'NAME',
            'PHONE NUMBER',
            'EMAIL',
            'DATE JOIN',
            'COMPANY',
            'ADDRESS',
        ];
    }
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
