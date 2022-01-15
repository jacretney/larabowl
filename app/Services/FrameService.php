<?php

namespace App\Services;

use App\Models\Frame;
use App\Models\Game;

class FrameService
{
    public function createFrame(Game $game): Frame
    {
        return new Frame([
            'game_id' => $game->id,
        ]);
    }
}
