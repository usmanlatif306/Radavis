<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Commoditie extends Model
{
    //use HasFactory;
    protected $fillable = [
        'name',
        'active',
        'color'
    ];

    public static function getsupplierofcommodity($id)
    {
        return DB::select("select id,name from suppliers INNER JOIN supplier_to_commodity ON suppliers.id = supplier_to_commodity.supplier_id where supplier_to_commodity.commodity_id=$id AND suppliers.active=1 ORDER BY suppliers.name;"); 
    }


}
