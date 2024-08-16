<?php

namespace Database\Factories;

use App\Models\OutageHistory;
use App\Models\OLT;
use App\Models\OutageTypes;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class OutageHistoryFactory extends Factory
{
    protected $model = OutageHistory::class;

    public function definition()
    {
        // Loop until a non-conflicting outage is generated
        do {
            // Define a random start date between now and one week back
            $startDate = $this->faker->dateTimeBetween('-1 week', 'now');

            // Define a random end date between the start date and now
            $endDate = $this->faker->dateTimeBetween($startDate, 'now');

            // Select a random OLT
            $olt = OLT::inRandomOrder()->first();

            // Check for conflicting outages at the same OLT
            $conflictingOutage = OutageHistory::where('olt_id', $olt->olt_id)
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_time', [$startDate, $endDate])
                          ->orWhereBetween('end_time', [$startDate, $endDate])
                          ->orWhere(function ($query) use ($startDate, $endDate) {
                              $query->where('start_time', '<=', $startDate)
                                    ->where('end_time', '>=', $endDate);
                          });
                })->exists();

        } while ($conflictingOutage); // Keep generating until no conflict is found

        // Select a random outage type
        $outageType = OutageTypes::inRandomOrder()->first();

        // Find a team that has both the resource required by the outage type and the resource at the OLT
        $team = Team::whereHas('resources', function ($query) use ($outageType, $olt) {
            $query->where('resources.resource_id', $outageType->resource_id);
        })->whereHas('resources', function ($query) use ($olt) {
            $query->where('resources.resource_id', $olt->resource_id);
        })->inRandomOrder()->first();

        // If no team matches both resource requirements, you may want to handle this case
        if (!$team) {
            // Fallback: select a team that has at least one of the required resources
            $team = Team::whereHas('resources', function ($query) use ($outageType, $olt) {
                $query->where('resources.resource_id', $outageType->resource_id)
                      ->orWhere('resources.resource_id', $olt->resource_id);
            })->inRandomOrder()->first();
        }

        return [
            'olt_id' => $olt->olt_id,
            'outage_type_id' => $outageType->outage_type_id,
            'start_time' => $startDate,
            'end_time' => $endDate,
            'duration' => Carbon::parse($startDate)->diffInSeconds(Carbon::parse($endDate)),
            'status' => false, // Ensure the outage is marked as resolved
            'resolution_details' => $this->faker->sentence,
            'team_id' => $team ? $team->team_id : null, // Handle the case where no team was found
        ];
    }
}
