<?php

namespace Database\Seeders;

use App\Models\User;
USE App\Models\Parish;
use App\Models\Town;
use App\Models\Resource;
use App\Models\CustomerType;
use App\Models\Customer;
use App\Models\OLT;
use App\Models\Team;
use App\Models\Outage_History;
use App\Models\SLA;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ParishSeeder::class,
            TownSeeder::class,
            ResourceSeeder::class,
            TeamSeeder::class,
            CustomerTypeSeeder::class,
            CustomerSeeder::class,
            OLTSeeder::class,
            OutageHistorySeeder::class,
            // SLASeeder::class,
        ]);
    }
}
