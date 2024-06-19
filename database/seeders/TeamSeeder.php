<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Resource;

class TeamSeeder extends Seeder
{
    public function run()
    {
        // Ensure there are resources in the database
        $resources = Resource::all();
        
        if ($resources->isEmpty()) {
            // If there are no resources, create some dummy resources
            $resourceNames = ['Bucket-Truck', 'Splicer', 'Cable Engineer', 'Fiber technician', 'Bucket vane'];

            foreach ($resourceNames as $name) {
                Resource::create(['resource_name' => $name]);
            }

            // Refresh the resources collection
            $resources = Resource::all();
        }

        // Define the teams and their types
        $teams = [
            ['team_name' => 'Team Alpha', 'team_type' => 'External'],
            ['team_name' => 'Team Bravo', 'team_type' => 'Internal'],
            ['team_name' => 'Team Charlie', 'team_type' => 'External'],
            ['team_name' => 'Team Delta', 'team_type' => 'Internal'],
            ['team_name' => 'Team Echo', 'team_type' => 'External'],
        ];

        // Create teams and associate them with random resources
        foreach ($teams as $teamData) {
            $team = new Team($teamData);
            $team->resource_id = $resources->random()->resource_id; // Ensure a valid resource_id is set
            $team->save();
        }
    }
}
