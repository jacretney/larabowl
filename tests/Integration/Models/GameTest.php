<?php

namespace Tests\Integration\Models;

use App\Models\Game;
use Tests\TestCase;

class GameTest extends TestCase
{
    public function testCanCreateGame(): void
    {
        $game = Game::factory()->create([
            'name' => 'Jims bowling game',
        ]);

        $this->assertEquals('Jims bowling game', $game->name);
    }
}
