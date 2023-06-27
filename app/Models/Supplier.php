<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    //use HasFactory;
    protected $fillable = [
        'name',
        'active'
    ];

    public static function getexitofsupplier($id)
    {
        return DB::select("select id,name from exits INNER JOIN exit_to_supplier ON exits.id = exit_to_supplier.exit_id where exit_to_supplier.supplier_id=$id AND exits.active=1 ORDER BY exits.name;"); 
    }
    public $timestamps = false;
}
