<?php

// database/seeders/ResourceSeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
    public function run()
    {
        $resources = [
            'Bucket-Truck',
            'Splicer',
            'Cable Engineer',
            'Fiber technician',
            'Bucket vane',
        ];

        foreach ($resources as $resource) {
            Resource::firstOrCreate(['resource_name' => $resource]);
        }
    }
}
