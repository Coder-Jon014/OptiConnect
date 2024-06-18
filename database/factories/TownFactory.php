<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Town;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Town>
 */
class TownFactory extends Factory
{
    protected $model = Town::class;

    public function definition()
    {
        return [
            'town_name' => $this->faker->city,
            'parish_id' => \App\Models\Parish::factory(), // this will generate a parish id
        ];
    }
}
