<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'NAMA',
            'TELEPON/WA',
            'EMAIL',
            'DIVISI',
            'ALAMAT',
        ];
    }
    public function collection()
    {
        return Employee::get([
            'employee_name',
            'phone_number',
            'employee_email',
            'employee_division',
            'employee_address',
        ]);
    }
}
