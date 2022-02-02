<?php

namespace Tests\Integration\Services;

use App\Models\Frame;
use App\Models\Game;
use App\Services\ScoreService;
use Database\Factories\FrameFactory;
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
        $this->assertEquals(20, $score);
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

        $score = $this->scoreService->calculateScore($frame);
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

        $score = $this->scoreService->calculateScore($frame);
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

        $score = $this->scoreService->calculateScore($frame);
        $this->assertEquals(8, $score->overallScore);
        $this->assertFalse($score->isSpare);
        $this->assertFalse($score->isStrike);
    }

    public function testSecondToLastThrowIsScoredCorrectlyIfStrike():void
    {
        $game = Game::factory()->create();
        $frame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 9,
                'throw_one_score' => 10,
                'throw_two_score' => 0,
            ]);

        $finalFrame = Frame::factory()
            ->for($game)
            ->create([
                'frame_number' => 10,
                'throw_one_score' => 10,
                'throw_two_score' => 10,
            ]);

        $score = $this->scoreService->calculateScore($frame);
        $this->assertEquals(30, $score->overallScore);

        // this needs a dataprovider to test all possible scenarios
    }

    /**
     * @dataProvider finalThrowDataProvider
     */
    public function testCalculateScoreReturnsCorrectScoreForFinalFrame(int $throwOne, int $throwTwo, int $throwThree, int $expectedScore): void
    {
        $game = Game::factory()->create();

        $finalFrame = Frame::factory()
            ->for($game)
            ->create([
                'throw_one_score' => $throwOne,
                'throw_two_score' => $throwTwo,
                'throw_three_score' => $throwThree,
            ]);

        $this->assertEquals($expectedScore, $this->scoreService->calculateFinalFrameScore($finalFrame)->overallScore);
    }

    public function finalThrowDataProvider(): array
    {
        return [
            // Gutter ball
            [
                'throw_one' => 0,
                'throw_two' => 0,
                'throw_three' => 0,
                'expected' => 0,
            ],
            // No specials
            [
                'throw_one' => 5,
                'throw_two' => 3,
                'throw_three' => 0,
                'expected' => 8,
            ],
            // No specials but being cheeky and having another go anyway
            [
                'throw_one' => 5,
                'throw_two' => 3,
                'throw_three' => 3,
                'expected' => 8,
            ],
            // Strike + no specials
            [
                'throw_one' => 10,
                'throw_two' => 3,
                'throw_three' => 5,
                'expected' => 18,
            ],
            // Strike + Strike + no specials
            [
                'throw_one' => 10,
                'throw_two' => 10,
                'throw_three' => 3,
                'expected' => 23,
            ],
            // Strike + Spare
            [
                'throw_one' => 10,
                'throw_two' => 5,
                'throw_three' => 5,
                'expected' => 20,
            ],
            // Spare + Strike
            [
                'throw_one' => 5,
                'throw_two' => 5,
                'throw_three' => 10,
                'expected' => 20,
            ],
            // Spare + no specials
            [
                'throw_one' => 5,
                'throw_two' => 5,
                'throw_three' => 3,
                'expected' => 13,
            ],
        ];
    }
}
