<?php

namespace App\Services;

use App\Models\Frame;
use App\Models\Game;
use Illuminate\Support\Collection;

class FrameService
{
    public function __construct(private ScoreService $scoreService) {}

    private const FRAME_COUNT = 10;

    public function generateFramesForGame(Game $game): Collection
    {
        $frames = new Collection();

        for ($i = 1; $i <= self::FRAME_COUNT; $i++) {
            $frame = new Frame([
                'game_id' => $game->id,
                'frame_number' => $i,
            ]);

            $frame->save();

            $frames->push($frame);
        }

        return $frames;
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
        if ($frame->throw_one_score + $frame->throw_two_score !== 10) {
            return $frame;
        }

        $frame->update([
            'throw_three_score' => $score,
        ]);

        return $frame;
    }

    public function calculateScore(Frame $frame): ?int
    {
        if ($frame->isStrike()) {
            return $this->scoreService->calculateStrikeScore($frame);
        }

        if ($frame->isSpare()) {
            return $this->scoreService->calculateSpareScore($frame);
        }

        return $this->scoreService->calculateScore($frame);
    }
}
