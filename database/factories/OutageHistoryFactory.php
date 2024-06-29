<?php

namespace Database\Factories;

use App\Models\OutageHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutageHistoryFactory extends Factory
{
    protected $model = OutageHistory::class;

    public function definition()
    {
        // Define a random start date from June 15, 2024
        $startDate = $this->faker->dateTimeBetween('2024-06-15', 'now');

        // Define a random end date between the start date and now
        $endDate = $this->faker->boolean(80) ? $this->faker->dateTimeBetween($startDate, 'now') : null;

        return [
            'olt_id' => \App\Models\OLT::inRandomOrder()->first()->olt_id,
            'team_id' => \App\Models\Team::inRandomOrder()->first()->team_id,
            'start_time' => $startDate,
            'end_time' => $endDate,
            'duration' => $endDate ? $endDate->getTimestamp() - $startDate->getTimestamp() : null, // Duration in seconds
            'resolution_details' => $this->faker->sentence,
            'status' => $endDate ? 0 : 1, // Set status to 0 (resolved) if end_time exists, otherwise 1 (active)
        ];
    }
}
