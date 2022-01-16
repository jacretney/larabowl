<?php

namespace App\Http\Resources;

use App\Models\Frame;
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
        return [
            'id' => $this->id,
            'game_id' => $this->game->id,
            'frame_number' => $this->frame_number,
            'throw_one_score' => $this->throw_one_score,
            'throw_two_score' => $this->throw_two_score,
            'throw_three_score' => $this->throw_three_score,
        ];
    }
}
