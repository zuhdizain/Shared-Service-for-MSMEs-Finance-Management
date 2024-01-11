<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    public function index()
    {
        if (Auth::user()->authorization_level == 2) {
            return view('HR_Apps.pelatihan.pelatihan', [
                'training' => Training::all()
            ]);
        } else {
            return view('HR_Apps.pelatihan.pelatihan', [
                'training' => Training::where('user_id', auth()->user()->id)->get()
            ]);
        }
    }

    public function create()
    {
        $division = Division::all();
        return view('HR_Apps.pelatihan.createPel', compact('division'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'employee_name' => 'required',
            'employee_email' => 'required',
            'employee_position' => 'required',
            'division_id' => 'required',
            'training_name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'training_institute' => 'required',
            'training_phone' => 'required',
            'training_email' => 'required|email:dns',
            'training_fee' => 'required',
            'training_address' => 'required'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Training::create($validatedData);

        return redirect('hr/training');
    }

    public function show($id)
    {
        $training = Training::findOrFail($id);
        return view('HR_Apps.pelatihan.detailPel', compact('training'));
    }

    public function edit($id)
    {
        return view('HR_Apps.pelatihan.editPel', [
            'training' => Training::findOrFail($id),
            'division' => Division::all()
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'employee_name' => 'required',
            'employee_email' => 'required',
            'employee_position' => 'required',
            'division_id' => 'required',
            'training_name' => 'required',
            'startDate' => 'required',
            'endDate' => 'required',
            'training_institute' => 'required',
            'training_phone' => 'required',
            'training_email' => 'required|email:dns',
            'training_fee' => 'required',
            'training_address' => 'required'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Training::where('id', $id)
            ->update($validatedData);

        return redirect('hr/training');
    }

    public function destroy(Training $training)
    {
        Training::destroy($training->id);

        return redirect('hr/training');
    }
}
