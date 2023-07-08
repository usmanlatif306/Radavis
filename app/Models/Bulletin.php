<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bulletin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'description', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'status' => 'bool',
    ];

    public function read(): HasOne
    {
        return $this->hasOne(BulletinRead::class)->where('user_id', auth()->id());
    }

    public function reads(): HasMany
    {
        return $this->hasMany(BulletinRead::class);
    }
}
