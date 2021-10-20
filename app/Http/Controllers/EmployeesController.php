<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::orderBy('id', 'desc')->limit(5)->get();
        return Inertia::render('Employees/Employees', compact('employees'));
    }

    public function create()
    {
        return Inertia::render('Employees/CreateEmployee');
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_name' => 'required',
            'phone_number' => 'required',
            'employee_email' => 'required|email',
            'employee_division' => 'required',
            'employee_address' => 'required',
        ]);

        $employee = $request->all();
        Employee::create($employee);

        return Redirect::route('employees.index')->with('message', 'Employee added successfully');
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return Inertia::render('Employees/EditEmployee', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_name' => 'required',
            'phone_number' => 'required',
            'employee_email' => 'required|email',
            'employee_division' => 'required',
            'employee_address' => 'required',
        ]);

        $employee = $request->all();
        Employee::where('id', $id)->update($employee);

        return Redirect::route('employees.index')->with('message', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return Redirect::back()->with('message', 'Employee deleted successfully');
    }
}
