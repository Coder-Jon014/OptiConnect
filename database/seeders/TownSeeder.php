<?php
// database/seeders/TownSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Town;

class TownSeeder extends Seeder
{
    public function run()
    {
        $towns = [
            ['town_name' => 'Negril', 'parish_id' => 1], // Westmoreland
            ['town_name' => 'St. Anns Bay', 'parish_id' => 4], // St. Ann
            ['town_name' => 'Mandeville', 'parish_id' => 5], // Manchester
            ['town_name' => 'Old Harbor', 'parish_id' => 2], // St. Catherine
            ['town_name' => 'St. Jago', 'parish_id' => 2], // St. Catherine
            ['town_name' => 'Bridgeport', 'parish_id' => 2], // St. Catherine
            ['town_name' => 'Dumfries', 'parish_id' => 3], // Kingston
            ['town_name' => 'Barbican', 'parish_id' => 3], // Kingston
            ['town_name' => 'Independence City', 'parish_id' => 2], // St. Catherine
        ];

        foreach ($towns as $town) {
            Town::create([
                'town_name' => $town['town_name'],
                'parish_id' => $town['parish_id'],
            ]);
        }
    }
}
