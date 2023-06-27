<?php

namespace App\Exports;

use App\Models\Exits;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExitsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Exits::all();
    }
}
