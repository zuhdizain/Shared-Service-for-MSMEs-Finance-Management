<?php

namespace App\Http\Controllers;

use App\Models\Attendee;
use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendController extends Controller
{
    public function index()
    {
        if (Auth::user()->authorization_level == 2) {
            return view('HR_Apps.absensi.absensi', [
                'attendee' => Attendee::all()
            ]);
        } else {
            return view('HR_Apps.absensi.absensi', [
                'attendee' => Attendee::where('user_id', auth()->user()->id)->get()
            ]);
        }
    }

    public function create()
    {
        return view('HR_Apps.absensi.createAbsensi', [
            'employee' => Employee::all(),
            'division' => Division::all()
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'division_id' => 'required',
            'employee_id' => 'required',
            'date'        => 'required',
            'description' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;

        Attendee::create($validatedData);

        return redirect('hr/absensi');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    // ---------------------------------------------- Function extend
    public function cetakAbsen()
    {
        return view('HR_Apps.absensi.unduhAbsensi');
    }

    public function cetakAbsenPertanggal($tglawal, $tglakhir)
    {
        $absenPerTanggal = Attendee::where('user_id', auth()->user()->id)
            ->whereBetween('date', [$tglawal, $tglakhir])->get();
        return view('HR_Apps.absensi.docAbsensi', compact('absenPerTanggal'));
    }
}
