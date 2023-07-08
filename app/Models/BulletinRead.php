<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BulletinRead extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['bulletin_id', 'user_id'];

    public function bulletin(): BelongsTo
    {
        return $this->belongsTo(Bulletin::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
