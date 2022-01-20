<?php

namespace App\ValueObjects;

class FrameScore
{
    public bool $isStrike;
    public bool $isSpare;
    public int $score;

    public function __construct(bool $isStrike = false, bool $isSpare = false, int $score = 0)
    {
        $this->isStrike = $isStrike;
        $this->isSpare = $isSpare;
        $this->score = $score;
    }

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

    public function setScore(int $score = 0): self
    {
        if ($score < 0) {
            throw new \DomainException('Score cannot be less than 0');
        }

        if ($this->isStrike && $score > 30) {
            throw new \DomainException('Score for a strike cannot be over 30');
        }

        if ($this->isSpare && $score > 20) {
            throw new \DomainException('Score for a spare cannot be over 20');
        }

        if (! $this->isSpare && ! $this->isStrike && $score > 10) {
            throw new \DomainException('Score cannot be over 10');
        }

        $this->score = $score;
        return $this;
    }
}
