<?php
// database/seeders/CustomerTypeSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerType;

class CustomerTypeSeeder extends Seeder
{
    public function run()
    {
        $customerTypes = [
            ['customer_type_name' => 'Residential', 'customer_value' => 32],
            ['customer_type_name' => 'Business', 'customer_value' => 1200],
        ];

        foreach ($customerTypes as $type) {
            CustomerType::firstOrCreate($type);
        }
    }
}

