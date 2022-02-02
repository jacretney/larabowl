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

        if ($frame->frame_number === 9) {
            // We need to treat the last bowl differently

            /** @var null|Frame $nextFrame */
            $nextFrame = Arr::get($nextFrames, 0);

            $frameTwo = new Frame();
            $frameThree = new Frame();

            $frameTwo->throw_one_score = $nextFrame->throw_one_score;
            $frameThree->throw_one_score = $nextFrame->throw_two_score;
        } else {
            /** @var null|Frame $frameTwo */
            $frameTwo = Arr::get($nextFrames, 0);

            /** @var null|Frame $frameThree */
            $frameThree = Arr::get($nextFrames, 1);
        }

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

    public function calculateScore(Frame $frame): FrameScore
    {
        $score = new FrameScore();

        if ($frame->frame_number === 10) {
            return $this->calculateFinalFrameScore($frame);
        }

        if ($frame->isStrike()) {
            $score->setIsStrike();
            $score->setOverallScore($this->calculateStrikeScore($frame));
        }

        if ($frame->isSpare()) {
            $score->setIsSpare();
            $score->setOverallScore($this->calculateSpareScore($frame));
        }

        if (! $frame->isStrike() && ! $frame->isSpare()) {
            $score->setOverallScore($frame->getScore());
        }

        $score->setThrowOneScore($frame->throw_one_score);
        $score->setThrowTwoScore($frame->throw_two_score);
        $score->setThrowThreeScore($frame->throw_three_score);

        return $score;
    }

    public function calculateFinalFrameScore(Frame $frame): FrameScore
    {
        $score = new FrameScore();

        $score->setThrowOneScore($frame->throw_one_score);
        $score->setThrowTwoScore($frame->throw_two_score);

        if ($frame->isStrike() || $frame->isSpare()) {
            $score->setThrowThreeScore($frame->throw_three_score);
        }

        $score->setOverallScore($score->throwOneScore + $score->throwTwoScore + $score->throwThreeScore);

        return $score;
    }
}
