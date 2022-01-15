<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    public function createGame(string $name): Game
    {
        return new Game([
            'name' => $name,
        ]);
    }
}
