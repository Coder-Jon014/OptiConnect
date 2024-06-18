<?php

namespace Database\Factories;

// database/factories/TeamFactory.php

use App\Models\Team;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition()
    {
        return [
            'team_name' => $this->faker->company,
            'team_type' => $this->faker->randomElement(['External', 'Internal']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Team $team) {
            $resources = Resource::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $team->resources()->attach($resources);
        });
    }
}
