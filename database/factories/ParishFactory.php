<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Parish;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parish>
 */
class ParishFactory extends Factory
{
    protected $model = Parish::class;

    public function definition()
    {
        return [
            'parish_name' => $this->faker->unique()->randomElement([
                'Westmoreland',
                'St Catherine',
                'Kingston',
                'St. Ann',
                'Manchester'
            ]),
        ];
    }
}
