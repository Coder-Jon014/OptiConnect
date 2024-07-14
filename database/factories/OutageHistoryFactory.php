<?php

namespace Database\Factories;

use App\Models\OutageHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OutageHistoryFactory extends Factory
{
    protected $model = OutageHistory::class;

    public function definition()
    {
        // Define a random start date
        $startDate = $this->faker->dateTimeBetween('-1 month', 'now');

        // Define a random end date between the start date and now
        $endDate = $this->faker->dateTimeBetween($startDate, 'now');


        return [
            'olt_id' => \App\Models\OLT::inRandomOrder()->first()->olt_id,
            'team_id' => \App\Models\Team::inRandomOrder()->first()->team_id,
            'start_time' => $startDate,
            'end_time' => $endDate,
            'duration' => $endDate->getTimestamp() - $startDate->getTimestamp(),
            'status' => false, // Ensure the outage is marked as resolved
            'resolution_details' => $this->faker->sentence,
        ];
    }
}
