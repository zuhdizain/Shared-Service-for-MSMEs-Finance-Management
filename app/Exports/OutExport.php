<?php

namespace App\Exports;

use App\Models\Out;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Controllers;

class OutExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Out::all();
    }
}
