<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Employee;
use App\Models\Pickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PicketsController extends Controller
{
    public function index()
    {
        if (Auth::user()->authorization_level == 2) {
            return view('HR_Apps.piket.pickets', [
                'pickets' => Pickets::all()
            ]);
        } else {
            return view('HR_Apps.piket.pickets', [
                'pickets' => Pickets::where('user_id', auth()->user()->id)->get()
            ]);
        }
    }

    public function create()
    {
        return view('HR_Apps.piket.createPiket', [
            'employee' => Employee::all(),
            'division' => Division::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'division_id' => 'required',
            'employee_id' => 'required',
            'days'        => 'required',
            'picket'      => 'required'
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Pickets::create($validatedData);

        return redirect('hr/picket');
    }

    public function show(Pickets $pickets)
    {
        // 
    }

    public function edit($id)
    {
        // 
    }

    public function update(Request $request, Pickets $pickets)
    {
        //
    }

    public function destroy(Pickets $pickets)
    {
        Pickets::destroy($pickets->id);
        return redirect('hr/picket');
    }

    public function allEmpPkc($days)
    {
        if ($days == "Senin") {
            $data = Pickets::where('days', $days)->get();
        } elseif ($days == "Selasa") {
            $data = Pickets::where('days', $days)->get();
        } elseif ($days == "Rabu") {
            $data = Pickets::where('days', $days)->get();
        } elseif ($days == "Kamis") {
            $data = Pickets::where('days', $days)->get();
        } elseif ($days == "Jumat") {
            $data = Pickets::where('days', $days)->get();
        } elseif ($days == "Sabtu") {
            $data = Pickets::where('days', $days)->get();
        }

        return view('HR_Apps.piket.picketDetails', compact('data'));
    }
}
