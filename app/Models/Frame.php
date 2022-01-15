<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Frame extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'game_id',
        'frame_number',
        'throw_one_score',
        'throw_two_score',
        'throw_three_score',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'id', 'game_id');
    }
}
