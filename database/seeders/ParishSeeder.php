<?php
// database/seeders/ParishSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParishSeeder extends Seeder
{
    public function run()
    {
        $parishes = [
            ['parish_id' => 1, 'parish_name' => 'Westmoreland'],
            ['parish_id' => 2, 'parish_name' => 'St Catherine'],
            ['parish_id' => 3, 'parish_name' => 'Kingston'],
            ['parish_id' => 4, 'parish_name' => 'St. Ann'],
            ['parish_id' => 5, 'parish_name' => 'Manchester'],
        ];        

        foreach ($parishes as $parish) {
            DB::table('parishes')->updateOrInsert(['parish_id' => $parish['parish_id']], $parish);
            //Update timestamp
            DB::table('parishes')->where('parish_id', $parish['parish_id'])->update(['created_at' => now(), 'updated_at' => now()]);
        }
    }
}
