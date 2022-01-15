<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Frame
 *
 * @property int $id
 * @property int $game_id
 * @property int $frame_number
 * @property int $throw_one_score
 * @property int|null $throw_two_score
 * @property int|null $throw_three_score
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @method static \Database\Factories\FrameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Frame newQuery()
 * @method static \Illuminate\Database\Query\Builder|Frame onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Frame query()
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereFrameNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereThrowOneScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereThrowThreeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereThrowTwoScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Frame withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Frame withoutTrashed()
 * @mixin \Eloquent
 */
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
        return $this->belongsTo(Game::class);
    }
}
