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
        $teams = [
            ['team_name' => 'Team Alpha', 'team_type' => 'External', 'resources' => [1, 2, 3, 4]],
            ['team_name' => 'Team Alpha', 'team_type' => 'Internal', 'resources' => [2, 3]],
            ['team_name' => 'Team Bravo', 'team_type' => 'External', 'resources' => [1, 5, 3, 6]],
            ['team_name' => 'Team Bravo', 'team_type' => 'Internal', 'resources' => [5, 2, 7]],
            ['team_name' => 'Team Charlie', 'team_type' => 'External', 'resources' => [5, 7, 2, 3, 4, 6]],
            ['team_name' => 'Team Charlie', 'team_type' => 'Internal', 'resources' => [6, 3]],
            ['team_name' => 'Team Delta', 'team_type' => 'External', 'resources' => [5, 2]],
            ['team_name' => 'Team Delta', 'team_type' => 'Internal', 'resources' => [5, 6, 4]],
            ['team_name' => 'Team Echo', 'team_type' => 'External', 'resources' => [2, 6, 3]],
            ['team_name' => 'Team Echo', 'team_type' => 'Internal', 'resources' => [5, 2]],
        ];

        foreach ($teams as $teamData) {
            $team = Team::create([
                'team_name' => $teamData['team_name'],
                'team_type' => $teamData['team_type'],
                'deployment_cost' => $teamData['team_type'] == 'External' ? 850 : 520,
            ]);

            if ($team->exists) {
                $team->resources()->attach($teamData['resources']);
                Log::info('Team Resource Attach Debug', ['team_id' => $team->team_id, 'resource_ids' => $teamData['resources']]);
            } else {
                Log::error('Failed to save team', ['team_data' => $teamData]);
            }
        }
    }
}