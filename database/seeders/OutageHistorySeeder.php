<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutageHistory;

class OutageHistorySeeder extends Seeder
{
    public function run()
    {
        OutageHistory::factory()->count(5)->create(); // Create 50 outage history entries
    }
}
