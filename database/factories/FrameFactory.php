<?php

namespace Database\Factories;

use App\Models\Frame;
use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class FrameFactory extends Factory
{
    /**
     * @return array
     */
    public function definition()
    {
        $throwOne = $this->faker->numberBetween(0, 11);
        $throwTwo = $this->faker->numberBetween(0, 10 - $throwOne) ?: null;

        return [
            'game_id' => fn () => Game::factory(),
            'frame_number' => $this->getOrder(),
            'throw_one_score' => $throwOne,
            'throw_two_score' => $throwTwo,
            'throw_three_score' => null,
        ];
    }

    private function getOrder(): int
    {
        /** @var Frame $latestFrame */
        $latestFrame = DB::table('frames')->latest('id')->first();

        if (!$latestFrame) {
            return 1;
        }

        return $latestFrame->frame_number + 1;
    }
}
