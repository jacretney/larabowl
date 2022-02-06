<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Game;
use Tests\TestCase;
use function route;

class GameControllerTest extends TestCase
{
    public function testCanGetAGame():void
    {
        $game = Game::factory()->create();

        $response = $this->get(route('api.games.get', [
            'game' => $game->id,
        ]));

        $response
            ->assertJsonFragment([
                'id' => $game->id,
                'name' => $game->name,
            ]);
    }

    public function testCanCreateAGame():void
    {
        $response = $this->post(route('api.games.create'), [
            'name' => 'A cool game',
        ]);

        $response
            ->assertJsonFragment([
                'name' => 'A cool game',
            ])
            ->assertJsonCount(10, 'data.frames');
    }

    public function testCanGetAllGames():void
    {
        Game::factory()
            ->count(10)
            ->create();

        $response = $this->get(route('api.games.all'));

        $response
            ->assertJsonCount(10, 'data');
    }
}
