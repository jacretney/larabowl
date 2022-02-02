<?php

namespace App\Http\Resources;

use App\Models\Frame;
use App\Services\ScoreService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Frame
 */
class FrameResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request = null): array
    {
        $scoreService = new ScoreService(); // There's probably a better way of doing this...
        $frameScore = $scoreService->calculateScore($this->resource);

        return [
            'id' => $this->id,
            'game_id' => $this->game->id,
            'frame_number' => $this->frame_number,
            'throw_one_score' => $frameScore->throwOneScore,
            'throw_two_score' => $frameScore->throwTwoScore,
            'throw_three_score' => $frameScore->throwThreeScore,
            'overall_score' => $frameScore->overallScore,
            'is_strike' => $frameScore->isStrike,
            'is_spare' => $frameScore->isSpare,
        ];
    }
}
