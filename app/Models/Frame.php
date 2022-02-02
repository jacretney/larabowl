<?php

namespace App\Models;

use Database\Factories\FrameFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * App\Models\Frame
 *
 * @property int $id
 * @property int $game_id
 * @property int $frame_number
 * @property int $throw_one_score
 * @property int|null $throw_two_score
 * @property int|null $throw_three_score
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Game|null $game
 * @method static FrameFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Frame newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Frame newQuery()
 * @method static Builder|Frame onlyTrashed()
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
 * @method static Builder|Frame withTrashed()
 * @method static Builder|Frame withoutTrashed()
 * @mixin Eloquent
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

    public function isLastFrame(): bool
    {
        return $this->frame_number === 10;
    }

    public function isStrike(): bool
    {
        return $this->throw_one_score === 10;
    }

    public function isSpare(): bool
    {
        return !$this->isStrike() && $this->throw_one_score + $this->throw_two_score === 10;
    }

    public function getScore(): int
    {
        return $this->throw_one_score + $this->throw_two_score + $this->throw_three_score;
    }

    /**
     * @return null|Collection<Frame>
     */
    public function getNextFrames(): ?Collection
    {
        $nextFrame = $this->frame_number + 1;
        $secondNextFrame = $this->frame_number + 2;

        return Frame::where('game_id', '=', $this->game_id)
            ->whereIn('frame_number', [$nextFrame, $secondNextFrame])
            ->get();
    }

    public function getNextFrame(): ?Frame
    {
        $nextFrame = $this->frame_number + 1;

        return Frame::where('game_id', '=', $this->game_id)
            ->where('frame_number', '=', $nextFrame)
            ->first();
    }
}
