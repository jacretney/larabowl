<?php

namespace App\Http\Controllers;

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
    public function setScore(Request $request, Frame $frame): JsonResponse
    {
        $throw = $request->input('throw', 1);
        $score = $request->input('score', 0);

        $frame = match ($throw) {
            1 => $this->frameService->setThrowOneScore($frame, $score),
            2 => $this->frameService->setThrowTwoScore($frame, $score),
            3 => $this->frameService->setThrowThreeScore($frame, $score),
            default => throw new DomainException('Unexpected match value'),
        };

        return $this->respond([
            'id' => $frame->id,
            'game_id' => $frame->game_id,
            'throw_one_score' => $frame->throw_one_score,
            'throw_two_score' => $frame->throw_two_score,
            'throw_three_score' => $frame->throw_three_score,
        ]);
    }
}
