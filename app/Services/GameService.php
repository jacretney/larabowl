<?php

namespace App\Services;

use App\Models\Game;

class GameService
{
    public function createGame(string $name): Game
    {
        $game = new Game([
           'name' => $name,
        ]);

        $game->save();

        return $game;
    }
}
