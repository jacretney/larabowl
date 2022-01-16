<?php

namespace App\Http\Controllers;

use App\Http\Resources\GameResource;
use App\Models\Frame;
use App\Models\Game;
use App\Services\FrameService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FrameController extends Controller
{
    private FrameService $frameService;

    public function __construct(FrameService $frameService)
    {
        $this->frameService = $frameService;
    }

    /**
     * @throws DomainException
     */
    public function setScore(Request $request, Game $game, Frame $frame): JsonResponse
    {
        if ($frame->game->id !== $game->id) {
            return $this->respond([], 400);
        }

        $throw = $request->input('throw', 1);
        $score = $request->input('score', 0);

        match ($throw) {
            1 => $this->frameService->setThrowOneScore($frame, $score),
            2 => $this->frameService->setThrowTwoScore($frame, $score),
            3 => $this->frameService->setThrowThreeScore($frame, $score),
            default => throw new DomainException('Unexpected match value'),
        };

        return $this->respond(new GameResource($game));
    }
}
