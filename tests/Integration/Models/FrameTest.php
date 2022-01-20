<?php

namespace Tests\Integration\Models;

use App\Models\Frame;
use App\Models\Game;
use Tests\TestCase;

class FrameTest extends TestCase
{
    public function testCanCreateFrame(): void
    {
        $frame = Frame::factory()
            ->for(Game::factory())
            ->create([
                'throw_one_score' => 2,
                'throw_two_score' => 8,
            ]);

        $this->assertEquals(2, $frame->throw_one_score);
        $this->assertEquals(8, $frame->throw_two_score);
    }
}
