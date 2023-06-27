<?php

namespace App\Exports;

use App\Models\rate;
use Maatwebsite\Excel\Concerns\FromCollection;

class RatesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return rate::all();
    }
}
