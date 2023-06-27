<?php

namespace App\Exports;

use App\Models\Destination;
use Maatwebsite\Excel\Concerns\FromCollection;

class DestinationsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Destination::all();
    }
}
