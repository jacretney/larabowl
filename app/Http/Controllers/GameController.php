<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Frame;
use App\Models\Game;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function create(Request $request): JsonResponse
    {
        $game = $this->gameService->createGame($request->input('name'));

        return $this->respond(new GameResource($game));
    }

    public function get(Game $game): JsonResponse
    {
        return $this->respond(new GameResource($game));
    }
}
