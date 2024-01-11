<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DivisionController extends Controller
{
    public function index()
    {
        if (Auth::user()->authorization_level == 2) {
            return view('HR_Apps.divisi.divisi', [
                'division' => Division::all()
            ]);
        } else {
            return view('HR_Apps.divisi.divisi', [
                'division' => Division::where('user_id', auth()->user()->id)->get()
            ]);
        }
    }

    public function create()
    {
        return view('HR_Apps.divisi.divisiCreate');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'division_name'    => 'required',
            'division_payroll' => 'required'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Division::create($validatedData);

        return redirect('hr/division');
    }

    public function show($id)
    {
        // $division = Division::findOrFail($id);
        // return view('HR_Apps.divisi.allDivisi', ['division' => $division]);
    }

    public function edit($id)
    {
        $division = Division::findOrFail($id);
        return view('HR_Apps.divisi.updateDivisi', ['division' => $division]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'division_name'    => 'required',
            'division_payroll' => 'required'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Division::where('id', $id)
            ->update($validatedData);

        return redirect('hr/division');
    }

    public function destroy(Division $division)
    {
        Division::destroy($division->id);
        return redirect('hr/division');
    }

    public function allEmpDvs($id)
    {
        $employee = Employee::where('division_id', $id)->get();
        return view('HR_Apps.divisi.allEmpDivisi', compact('employee'));
    }
}
