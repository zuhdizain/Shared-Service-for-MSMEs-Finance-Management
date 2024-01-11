<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Histories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HistoryController extends Controller
{
    public function index()
    {
        if (Auth::user()->authorization_level == 2) {
            return view('HR_Apps.kepegawaian.history', [
                'histories' => Histories::all()
            ]);
        } else {
            return view('HR_Apps.kepegawaian.history', [
                'histories' => Histories::where('user_id', auth()->user()->id)->get()
            ]);
        }
    }

    public function create()
    {
        $division = Division::all();
        return view('HR_Apps.kepegawaian.createHistory', compact('division'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'position' => 'required',
            'division_id' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'religion' => 'required',
            'age' => 'required',
            'marriage' => 'required',
            'child' => 'required',
            'status' => 'required',
            'acceptanceDate' => 'required',
            'outDate' => 'required',
            'hospitalChart' => 'required',
            'address' => 'required',
            'statement' => 'required'
        ]);

        if ($request->file('statementLetter')) {
            $validatedData['statementLetter'] = $request->file('statementLetter')->store('files');
        }

        $validatedData['user_id'] = auth()->user()->id;

        Histories::create($validatedData);

        return redirect('hr/history');
    }

    public function show($id)
    {
        $histories = Histories::findOrFail($id);
        return view('HR_Apps.kepegawaian.historyDetails', ['histories' => $histories]);
    }

    public function edit($id)
    {
        // return view('HR_Apps.kepegawaian.editHistory', [
        //     'employee' => Histories::findOrFail($id),
        //     'division' => Division::all()
        // ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Histories $history)
    {
        if ($history->oldFile) {
            Storage::delete($history->oldFile);
        }

        Histories::destroy($history->id);
        return redirect('history')->with('success', 'Data berhasil dihapus!');
    }

    // public function download()
    // {
    //     return Storage::download('statementLetter');
    // }
}
