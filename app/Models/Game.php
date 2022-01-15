<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function frames(): HasMany
    {
        return $this->hasMany(Frame::class, 'game_id', 'id');
    }
}
