<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispatchLog extends Model
{
    use HasFactory;
    protected $table = 'dispatch_log';
    protected $fillable = [
        'datetime',
        'dispatch_id',
        'user_id',
        'note'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
