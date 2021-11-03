<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;

class EmployeesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
