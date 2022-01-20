<?php

namespace Tests\Integration\Services;

use App\Models\Frame;
use App\Models\Game;
use App\Services\ScoreService;
use Tests\TestCase;

class ScoreServiceTest extends TestCase
{
    private ScoreService $scoreService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->scoreService = new ScoreService();
    }

    public function testCanCalculateStrikeScoreIfNoNextFrame():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => 10,
            ]);

        $score = $this->scoreService->calculateStrikeScore($frame);
        $this->assertEquals(10, $score);
    }

    public function testCanCalculateStrikeScoreIfNextFrameIsNotSpecial():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 1,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 2,
                'throw_one_score' => 5,
                'throw_two_score' => 3,
            ]);

        $score = $this->scoreService->calculateStrikeScore($frame);
        $this->assertEquals(18, $score);
    }

    public function testCanCalculateStrikeScoreIfNextFrameIsSpare():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 1,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 2,
                'throw_one_score' => 5,
                'throw_two_score' => 5,
            ]);

        $score = $this->scoreService->calculateStrikeScore($frame);
        $this->assertEquals(15, $score);
    }

    public function testCanCalculateStrikeScoreIfNextFrameIsStrike():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 1,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 2,
                'throw_one_score' => 10,
            ]);

        $score = $this->scoreService->calculateStrikeScore($frame);
        $this->assertEquals(20, $score);
    }

    public function testCanCalculateStrikeScoreIfNextTwoFramesAreStrikes():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 1,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 2,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 3,
                'throw_one_score' => 10,
            ]);

        $score = $this->scoreService->calculateStrikeScore($frame);
        $this->assertEquals(30, $score);
    }

    public function testCanCalculateStrikeScoreIfNextThreeFramesAreStrikes():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 1,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 2,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 3,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 4,
                'throw_one_score' => 10,
            ]);

        $score = $this->scoreService->calculateStrikeScore($frame);
        $this->assertEquals(30, $score);
    }

    public function testCanCalculateStrikeScoreIfNextFramesAreStrikeAndThenSpare():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 1,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 2,
                'throw_one_score' => 10,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 3,
                'throw_one_score' => 5,
                'throw_two_score' => 5,
            ]);

        $score = $this->scoreService->calculateStrikeScore($frame);
        $this->assertEquals(25, $score);
    }

    public function testCanCalculateSpareScoreIfNoNextFrame():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => 7,
                'throw_two_score' => 3,
            ]);

        $score = $this->scoreService->calculateSpareScore($frame);
        $this->assertEquals(10, $score);
    }

    public function testCanCalculateSpareScoreWithNextFrame():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => 7,
                'throw_two_score' => 3,
            ]);

        Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => 7,
            ]);

        $score = $this->scoreService->calculateSpareScore($frame);
        $this->assertEquals(17, $score);
    }

    public function testCalculateScoreReturnsAFrameScoreForAStrike():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => 10,
            ]);

        $score = $this->scoreService->calculcateScore($frame);
        $this->assertEquals(10, $score->overallScore);
        $this->assertTrue($score->isStrike);
        $this->assertFalse($score->isSpare);
    }

    public function testCalculateScoreReturnsAFrameScoreForASpare():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => 5,
                'throw_two_score' => 5,
            ]);

        $score = $this->scoreService->calculcateScore($frame);
        $this->assertEquals(10, $score->overallScore);
        $this->assertTrue($score->isSpare);
        $this->assertFalse($score->isStrike);
    }

    public function testCalculateScoreReturnsAFrameScoreForANormalScore():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => 5,
                'throw_two_score' => 3,
            ]);

        $score = $this->scoreService->calculcateScore($frame);
        $this->assertEquals(8, $score->overallScore);
        $this->assertFalse($score->isSpare);
        $this->assertFalse($score->isStrike);
    }
}
