<?php

namespace App\Http\Controllers;

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

        return $this->respond([
            'id' => $game->id,
            'name' => $game->name,
            'frames' => $game->frames->map(function (Frame $frame) {
                return [
                    'frame_number' => $frame->frame_number,
                    'throw_one_score' => $frame->throw_one_score,
                    'throw_two_score' => $frame->throw_two_score,
                    'throw_three_score' => $frame->throw_three_score,
                ];
            })
        ]);
    }

    public function get(Game $game): JsonResponse
    {
        return $this->respond([
            'id' => $game->id,
            'name' => $game->name,
            'frames' => $game->frames->map(function (Frame $frame) {
                return [
                    'id' => $frame->id,
                    'frame_number' => $frame->frame_number,
                    'throw_one_score' => $frame->throw_one_score,
                    'throw_two_score' => $frame->throw_two_score,
                    'throw_three_score' => $frame->throw_three_score,
                ];
            })
        ]);
    }
}
