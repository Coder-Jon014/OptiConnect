<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OutageHistory;

class OutageHistorySeeder extends Seeder
{
    public function run()
    {
        OutageHistory::factory()->count(15)->create(); // Create 10 outage history entries
    }
}
