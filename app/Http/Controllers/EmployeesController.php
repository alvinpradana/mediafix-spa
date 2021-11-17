<?php

namespace App\Http\Controllers;

use App\Exports\EmployeesExport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class EmployeesController extends Controller
{
    public function index(Request $request)
    {
        $employees = Employee::query()
            ->when($request['search'], function ($query, $search) {
                $query->where('employee_name', 'like', '%' . $search . '%');
            })
            ->latest()
            ->where('employees.user_id', '=', auth()->user()->id)
            ->paginate(6)
            ->onEachSide(1)
            ->withQueryString();

        return Inertia::render('Employees/Employees', [
            'employees' => $employees,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $user = auth()->user()->id;
        return Inertia::render('Employees/CreateEmployee', compact('user'));
    }

    public function store(Request $request)
    {
        $attr = $request->validate([
            'user_id' => ['required'],
            'employee_name' => ['required'],
            'phone_number' => ['required'],
            'employee_email' => ['required', 'email'],
            'employee_division' => ['required'],
            'employee_address' => ['required'],
        ]);

        Employee::create($attr);
        return Redirect::route('employees.index')->with('alert_success', 'Employee has been added successfully.');
    }

    public function edit($id)
    {
        $employee = Employee::where('employees.user_id', '=', auth()->user()->id)->findOrFail($id);
        return Inertia::render('Employees/EditEmployee', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $attr = $request->validate([
            'employee_name' => ['required'],
            'phone_number' => ['required'],
            'employee_email' => ['required', 'email'],
            'employee_division' => ['required'],
            'employee_address' => ['required'],
        ]);

        Employee::where('id', $id)->update($attr);
        return Redirect::route('employees.index')->with('alert_success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        Employee::where('employees.user_id', '=', auth()->user()->id)->findOrFail($id)->delete();
        return Redirect::back()->with('alert_success', 'Employee deleted successfully.');
    }

    public function export()
    {
        return Excel::download(new EmployeesExport, 'Employee-'. date('Y-m-d') .'.xlsx');
    }
}
