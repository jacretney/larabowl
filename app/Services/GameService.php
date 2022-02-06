<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Collection;

class GameService
{
    public function __construct(
        private FrameService $frameService,
    ){}

    public function createGame(string $name): Game
    {
        $game = new Game([
           'name' => $name,
        ]);

        $game->save();

        $this->frameService->generateFramesForGame($game);

        return $game;
    }

    public function getAllGames(): Collection
    {
        return Game::all();
    }
}
