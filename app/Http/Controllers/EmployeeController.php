<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index()
    {
        if (Auth::user()->authorization_level == 2) {
            return view('HR_Apps.kepegawaian.tableEmployeeData', [
                'employees' => Employee::all()
            ]);
        } else {
            return view('HR_Apps.kepegawaian.tableEmployeeData', [
                'employees' => Employee::where('user_id', auth()->user()->id)->get()
            ]);
        }
    }

    public function create()
    {
        $division = Division::all();
        return view('HR_Apps.kepegawaian.createEmployee', compact('division'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_name' => 'required',
            'employee_email' => 'required|email:dns',
            'employee_position' => 'required',
            'division_id' => 'required',
            'employee_phone' => 'required',
            'employee_gender' => 'required',
            'employee_religion' => 'required',
            'employee_age' => 'required',
            'employee_marriage' => 'required',
            'employee_child' => 'required',
            'employee_status' => 'required',
            'employee_acceptanceDate' => 'required',
            'last_education' => 'required',
            'employee_hospitalChart' => 'required',
            'employee_address' => 'required',
            'employee_image' => 'image|file|max:1024'
        ]);

        if ($request->file('employee_image')) {
            $validatedData['employee_image'] = $request->file('employee_image')->store('employeeImage');
        }

        $validatedData['user_id'] = auth()->user()->id;

        Employee::create($validatedData);

        return redirect('hr/employee');
    }

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        return view('HR_Apps.kepegawaian.employee', ['employee' => $employee]);
    }

    public function edit($id)
    {
        return view('HR_Apps.kepegawaian.editEmployee', [
            'employee' => Employee::findOrFail($id),
            'division' => Division::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'employee_name' => 'required',
            'employee_email' => 'required|email:dns',
            'employee_position' => 'required',
            'division_id' => 'required',
            'employee_phone' => 'required',
            'employee_gender' => 'required',
            'employee_religion' => 'required',
            'employee_age' => 'required',
            'employee_marriage' => 'required',
            'employee_child' => 'required',
            'employee_status' => 'required',
            'employee_acceptanceDate' => 'required',
            'last_education' => 'required',
            'employee_hospitalChart' => 'required',
            'employee_address' => 'required',
            'employee_image' => 'image|file|max:1024'
        ]);

        if ($request->file('employee_image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['employee_image'] = $request->file('employee_image')->store('employeeImage');
        }

        $validatedData['user_id'] = auth()->user()->id;

        Employee::where('id', $id)
            ->update($validatedData);

        return redirect('hr/employee');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->oldImage) {
            Storage::delete($employee->oldImage);
        }

        Employee::destroy($employee->id);
        return redirect('hr/employee');
    }
}
