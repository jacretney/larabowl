<?php

namespace App\Services;

use App\Models\Frame;
use App\ValueObjects\FrameScore;
use Illuminate\Support\Arr;

class ScoreService
{
    public function calculateStrikeScore(Frame $frame): int
    {
        $nextFrames = $frame->getNextFrames();
        $scoreFromFrames = 0;

        $frameOne = $frame;
        /** @var null|Frame $frameTwo */
        $frameTwo = Arr::get($nextFrames, 0);

        /** @var null|Frame $frameThree */
        $frameThree = Arr::get($nextFrames, 1);

        if ($frameTwo?->isStrike()) {
            $scoreFromFrames += $frameTwo->getScore();
            $scoreFromFrames += $frameThree?->throw_one_score; // Add the score from the next strike
        }

        if ($frameTwo?->isSpare()) {
            $scoreFromFrames += $frameTwo->throw_one_score;
        }

        if ($frameTwo && ! $frameTwo->isStrike() && ! $frameTwo->isSpare()) {
            $scoreFromFrames += $frameTwo->getScore();
        }

        return $frameOne->getScore() + $scoreFromFrames;
    }

    public function calculateSpareScore(Frame $frame): int
    {
        $nextFrame = $frame->getNextFrame();

        return $frame->getScore() + $nextFrame?->throw_one_score;
    }

    public function calculcateScore(Frame $frame): FrameScore
    {
        $score = new FrameScore();

        if ($frame->isStrike()) {
            $score->setIsStrike();
            $score->setScore($this->calculateStrikeScore($frame));
        }

        if ($frame->isSpare()) {
            $score->setIsSpare();
            $score->setScore($this->calculateSpareScore($frame));
        }

        if (! $frame->isStrike() && ! $frame->isSpare()) {
            $score->setScore($frame->getScore());
        }

        return $score;
    }
}
