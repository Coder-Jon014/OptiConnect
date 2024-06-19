<?php

namespace Database\Factories;

use App\Models\OLT;
use Illuminate\Database\Eloquent\Factories\Factory;

class OLTFactory extends Factory
{
    protected $model = OLT::class;

    public function definition()
    {
        return [
            'olt_name' => $this->faker->word,
            'parish_id' => \App\Models\Parish::factory(),
            'town_id' => \App\Models\Town::factory(),
            'customer_count' => $this->faker->numberBetween(0, 20000),
            'business_customer_count' => $this->faker->numberBetween(0, 5000),
            'residential_customer_count' => $this->faker->numberBetween(0, 15000),
            'resource_id' => \App\Models\Resource::factory(),
            'olt_value' => $this->faker->numberBetween(1000, 100000),
            'rank' => $this->faker->numberBetween(1, 5),
            'level' => $this->faker->randomElement(['High', 'Low']),
        ];
    }
}
