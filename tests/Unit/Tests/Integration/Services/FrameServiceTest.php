<?php

namespace Tests\Integration\Services;

use App\Models\Frame;
use App\Models\Game;
use App\Services\FrameService;
use Tests\TestCase;

class FrameServiceTest extends TestCase
{
    private FrameService $frameService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->frameService = new FrameService();
    }

    public function testCanCreateFramesForGame():void
    {
        $game = Game::factory()->create();

        $frames = $this->frameService->generateFramesForGame($game);

        $this->assertCount(10, $frames);
        $this->assertCount(10, $game->frames);
    }

    public function testSetThrowOneScore()
    {
        $frame = Frame::factory()->create();

        $this->frameService->setThrowOneScore($frame, 5);

        $this->assertEquals(5, $frame->throw_one_score);
    }

    public function testSetThrowTwoScore()
    {
        $frame = Frame::factory()->create([
            'throw_one_score' => 5,
        ]);

        $this->frameService->setThrowTwoScore($frame, 5);

        $this->assertEquals(5, $frame->throw_two_score);
    }

    public function testCannotSetThrowTwoScoreIfThrowOneIsTen():void
    {
        $frame = Frame::factory()->create([
            'throw_one_score' => 10,
        ]);

        $this->frameService->setThrowTwoScore($frame, 5);

        $this->assertNull($frame->throw_two_score);
    }

    public function testSetThrowThreeScore()
    {
        $frame = Frame::factory()->create([
            'throw_one_score' => 5,
            'throw_two_score' => 5,
        ]);

        $this->frameService->setThrowThreeScore($frame, 5);

        $this->assertEquals(5, $frame->throw_three_score);
    }

    public function testCannotSetThrowThreeScoreIfThrowOneAndTwoNotEqualToTen():void
    {
        $frame = Frame::factory()->create([
            'throw_one_score' => 1,
            'throw_two_score' => 2,
        ]);

        $this->frameService->setThrowThreeScore($frame, 5);

        $this->assertNull($frame->throw_three_score);
    }
}
