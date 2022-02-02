<?php

namespace App\ValueObjects;

class FrameScore
{
    public bool $isStrike = false;
    public bool $isSpare = false;
    public int $overallScore = 0;
    public ?int $throwOneScore = null;
    public ?int $throwTwoScore = null;
    public ?int $throwThreeScore = null;
    public ?int $rollingScore = null;

    public function setIsStrike(bool $isStrike = true): self
    {
        if ($this->isSpare) {
            throw new \DomainException('Cannot set this as a strike if it is already a spare');
        }

        $this->isStrike = $isStrike;
        return $this;
    }

    public function setIsSpare(bool $isSpare = true): self
    {
        if ($this->isStrike) {
            throw new \DomainException('Cannot set this as a spare if it is already a strike');
        }

        $this->isSpare = $isSpare;
        return $this;
    }

    public function setOverallScore(int $overallScore = 0): self
    {
        if ($overallScore < 0) {
            throw new \DomainException('Score cannot be less than 0');
        }

        if ($this->isStrike && $overallScore > 30) {
            throw new \DomainException('Score for a strike cannot be over 30');
        }

        if ($this->isSpare && $overallScore > 20) {
            throw new \DomainException('Score for a spare cannot be over 20');
        }

        $this->overallScore = $overallScore;
        return $this;
    }

    public function setThrowOneScore($score = 0): self
    {
        $this->throwOneScore = $score;
        return $this;
    }

    public function setThrowTwoScore($score = 0): self
    {
        $this->throwTwoScore = $score;
        return $this;
    }

    public function setThrowThreeScore($score = 0): self
    {
        $this->throwThreeScore = $score;
        return $this;
    }

    public function setRollingScore($score = 0): self
    {
        $this->rollingScore = $score;
        return $this;
    }
}
