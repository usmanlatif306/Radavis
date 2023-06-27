<?php

namespace App\Exports;

use App\Models\Via;
use Maatwebsite\Excel\Concerns\FromCollection;

class ViasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Via::all();
    }
}
