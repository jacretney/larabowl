<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'My bowling game',
        ];
    }
}
