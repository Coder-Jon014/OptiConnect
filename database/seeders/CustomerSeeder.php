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
        $stAnnBayTownId = 2; // Assuming this is the correct ID for St. Ann's Bay
        $mandevilleTownId = 3; // Assuming this is the correct ID for Mandeville
        $oldHarborTownId = 4; // Assuming this is the correct ID for Old Harbor
        $stJagoTownId = 5; // Assuming this is the correct ID for St. Jago
        $bridgeportTownId = 6; // Assuming this is the correct ID for Bridgeport
        $dumfriesTownId = 7; // Assuming this is the correct ID for Dumfries
        $barbicanTownId = 8; // Assuming this is the correct ID for Barbican
        $independenceCityTownId = 9; // Assuming this is the correct ID for Independence City

        $businessTypeId = CustomerType::where('customer_type_name', 'Business')->first()->customer_type_id;
        $residentialTypeId = CustomerType::where('customer_type_name', 'Residential')->first()->customer_type_id;

        // Create 4 Business Customers
        Customer::factory()->count(10)->create([
            'town_id' => $negrilTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 46 Residential Customers
        Customer::factory()->count(20)->create([
            'town_id' => $negrilTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 500 Business Customers
        Customer::factory()->count(10)->create([
            'town_id' => $stAnnBayTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 1500 Residential Customers
        Customer::factory()->count(20)->create([
            'town_id' => $stAnnBayTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 800 Business Customers
        Customer::factory()->count(10)->create([
            'town_id' => $mandevilleTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 8200 Residential Customers
        Customer::factory()->count(20)->create([
            'town_id' => $mandevilleTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 1000 Business Customers
        Customer::factory()->count(10)->create([
            'town_id' => $oldHarborTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 10000 Residential Customers
        Customer::factory()->count(20)->create([
            'town_id' => $oldHarborTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 2000 Business Customers
        Customer::factory()->count(10)->create([
            'town_id' => $stJagoTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 14000 Residential Customers
        Customer::factory()->count(20)->create([
            'town_id' => $stJagoTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 2000 Business Customers
        Customer::factory()->count(10)->create([
            'town_id' => $bridgeportTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 21000 Residential Customers
        Customer::factory()->count(20)->create([
            'town_id' => $bridgeportTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 1200 Business Customers
        Customer::factory()->count(10)->create([
            'town_id' => $dumfriesTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 9800 Residential Customers
        Customer::factory()->count(10)->create([
            'town_id' => $dumfriesTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 500 Business Customers
        Customer::factory()->count(20)->create([
            'town_id' => $barbicanTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 7500 Residential Customers
        Customer::factory()->count(10)->create([
            'town_id' => $barbicanTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 1000 Business Customers
        Customer::factory()->count(20)->create([
            'town_id' => $independenceCityTownId,
            'customer_type_id' => $businessTypeId,
        ]);

        // Create 12000 Residential Customers
        Customer::factory()->count(10)->create([
            'town_id' => $independenceCityTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
    }
}
