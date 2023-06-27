<?php

namespace App\Exports;

use App\Models\Commoditie;
use Maatwebsite\Excel\Concerns\FromCollection;

class CommoditiesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Commoditie::all();
    }
}
