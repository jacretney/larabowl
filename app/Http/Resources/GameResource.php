<?php

namespace App\Http\Resources;

use App\Models\Frame;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Game
 */
class GameResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request = null): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'frames' => $this->frames->map(function (Frame $frame) use ($request) {
                return (new FrameResource($frame))->toArray($request);
            })
        ];
    }
}
