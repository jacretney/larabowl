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

    public function setThrowOneScore(Frame $frame, int $score): Frame
    {
        $frame->update([
            'throw_one_score' => $score,
        ]);

        return $frame;
    }

    public function setThrowTwoScore(Frame $frame, int $score): Frame
    {
        if ($frame->throw_one_score === 10) {
            return $frame;
        }

        $frame->update([
            'throw_two_score' => $score,
        ]);

        return $frame;
    }

    public function setThrowThreeScore(Frame $frame, int $score): Frame
    {
//        dd($frame->throw_one_score + $frame->throw_two_score);

        if ($frame->throw_one_score + $frame->throw_two_score !== 10) {
            return $frame;
        }

        $frame->update([
            'throw_three_score' => $score,
        ]);

        return $frame;
    }
}
