<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Via extends Model
{
    //use HasFactory;
    protected $fillable = [
        'name', 'active', 'user_id', 'contact_name', 'email', 'phone', 'last_dispatch_at', 'trucks', 'equip_type', 'service_area'
    ];
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'last_dispatch_at' => 'date',
        'equip_type' => 'array',
        'service_area' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
