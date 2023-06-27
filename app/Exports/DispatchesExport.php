<?php

namespace App\Exports;

use App\Models\dispatch;
use Maatwebsite\Excel\Concerns\FromCollection;

class DispatchesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return dispatch::all();
    }
}
