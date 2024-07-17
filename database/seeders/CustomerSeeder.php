<?php
// database/seeders/CustomerSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\CustomerType;
use App\Models\Town;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $negrilTownId = 1; // Assuming this is the correct ID for Negril
        $businessTypeId = CustomerType::where('customer_type_name', 'Business')->first()->customer_type_id;

        // Create a single Business Customer with the specified phone number
        Customer::factory()->create([
            'customer_name' => 'Test Customer',
            'telephone' => '+18762922254',
            'town_id' => $negrilTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->create([
            'customer_name' => 'Test Customer 1',
            'telephone' => '+18765528469',
            'town_id' => $negrilTownId,
            'customer_type_id' => $businessTypeId,
        ]);
    }
}
