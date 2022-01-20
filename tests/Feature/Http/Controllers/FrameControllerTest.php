<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Frame;
use App\Models\Game;
use Tests\TestCase;
use function route;

class FrameControllerTest extends TestCase
{
    public function testCanSetThrowOneScore():void
    {
        $frame = Frame::factory()
            ->for(Game::factory())
            ->create([
                'throw_one_score' => null,
                'throw_two_score' => null,
            ]);

        $response = $this->post(route('api.game.frame.set-score', [
            'frame' => $frame->id,
            'game' => $frame->game->id,
        ]), [
            'throw' => 1,
            'score' => 5,
        ]);

        $response
            ->assertOk()
            ->assertJsonFragment([
                'game_id' => $frame->game->id,
                'throw_one_score' => 5,
                'throw_two_score' => null,
                'throw_three_score' => null,
            ]);
    }

    public function testCanSetThrowTwoScore():void
    {
        $frame = Frame::factory()
            ->for(Game::factory())
            ->create([
                'throw_one_score' => 3,
                'throw_two_score' => null,
            ]);


        $response = $this->post(route('api.game.frame.set-score', [
            'frame' => $frame->id,
            'game' => $frame->game->id,
        ]), [
            'throw' => 2,
            'score' => 5,
        ]);

        $response
            ->assertOk()
            ->assertJsonFragment([
                'game_id' => $frame->game->id,
                'throw_one_score' => 3,
                'throw_two_score' => 5,
                'throw_three_score' => null,
            ]);
    }

    public function testCanSetThrowThreeScore():void
    {
        $frame = Frame::factory()
            ->for(Game::factory())
            ->create([
                'throw_one_score' => 8,
                'throw_two_score' => 2,
            ]);

        $response = $this->post(route('api.game.frame.set-score', [
            'frame' => $frame->id,
            'game' => $frame->game->id,
        ]), [
            'throw' => 3,
            'score' => 5,
        ]);

        $response
            ->assertOk()
            ->assertJsonFragment([
                'game_id' => $frame->game->id,
                'throw_one_score' => 8,
                'throw_two_score' => 2,
                'throw_three_score' => 5,
            ]);
    }
}
