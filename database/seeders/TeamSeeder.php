<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Resource;
use Illuminate\Support\Facades\Log;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $resources = Resource::all();

        Log::info('Resources Debug', ['resources' => $resources]);

        $teams = [
            ['team_name' => 'Team Alpha', 'team_type' => 'External'],
            ['team_name' => 'Team Alpha', 'team_type' => 'Internal'],
            ['team_name' => 'Team Bravo', 'team_type' => 'External'],
            ['team_name' => 'Team Bravo', 'team_type' => 'Internal'],
            ['team_name' => 'Team Charlie', 'team_type' => 'External'],
            ['team_name' => 'Team Charlie', 'team_type' => 'Internal'],
            ['team_name' => 'Team Delta', 'team_type' => 'External'],
            ['team_name' => 'Team Delta', 'team_type' => 'Internal'],
            ['team_name' => 'Team Echo', 'team_type' => 'External'],
            ['team_name' => 'Team Echo', 'team_type' => 'Internal'],
        ];

        foreach ($teams as $teamData) {
            $team = new Team($teamData);
            $team->save();

            if ($team->exists) {
                $resourceIds = $resources->random(rand(1, 3))->pluck('resource_id')->toArray();
                $team->resources()->attach($resourceIds);

                Log::info('Team Resource Attach Debug', ['team_id' => $team->team_id, 'resource_ids' => $resourceIds]);
            } else {
                Log::error('Failed to save team', ['team_data' => $teamData]);
            }
        }
    }
}
