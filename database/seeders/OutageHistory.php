<?php

// database/seeders/OutageHistorySeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\OutageHistory;

class OutageHistorySeeder extends Seeder
{
    public function run()
    {
        OutageHistory::factory()->count(50)->create(); // Create 50 outage history entries
    }
}
