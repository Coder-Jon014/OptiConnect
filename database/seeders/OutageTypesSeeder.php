<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Resource;
use App\Models\OutageTypes;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class OutageTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outage_types = [
            ['name' => 'Fiber Break', 'resource_id' => 3],
            ['name' => 'Commercial Power Outage', 'resource_id' => 5],
            ['name' => 'Generator Gas Empty', 'resource_id' => 4],
        ];

        foreach ($outage_types as $type) {
            OutageTypes::create([
                'outage_type_name' => $type['name'],
                'resource_id' => $type['resource_id'],
            ]);

            Log::info('Outage Type Created', [
                'name' => $type['name'],
                'resource_id' => $type['resource_id']
            ]);
        }
    }
}