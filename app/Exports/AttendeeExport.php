<?php

namespace App\Exports;

use App\Models\Attendee;
use Maatwebsite\Excel\Concerns\FromCollection;

class AttendeeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Attendee::all();
    }
}
