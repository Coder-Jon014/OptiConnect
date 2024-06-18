<?php

// database/seeders/TeamSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\Resource;

class TeamSeeder extends Seeder
{
    public function run()
    {
        $teams = [
            ['team_name' => 'Team Alpha', 'team_type' => 'External'],
            ['team_name' => 'Team Bravo', 'team_type' => 'Internal'],
            ['team_name' => 'Team Charlie', 'team_type' => 'External'],
            ['team_name' => 'Team Delta', 'team_type' => 'Internal'],
            ['team_name' => 'Team Echo', 'team_type' => 'External'],
        ];

        foreach ($teams as $teamData) {
            $team = Team::create([
                'team_name' => $teamData['team_name'],
                'team_type' => $teamData['team_type'],
            ]);

            $resources = Resource::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $team->resources()->attach($resources);
        }
    }
}
