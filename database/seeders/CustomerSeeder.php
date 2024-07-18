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

        $negrilTownId = 1;
        $stAnnsBayTownId = 4;
        $mandevilleTownId = 5;
        $oldHarborTownId = 2;
        $stJagoTownId = 2;
        $bridgeportTownId = 2;
        $dumfriesTownId = 3;
        $barbicanTownId = 3;
        $independenceCityTownId = 2;

        $residentialTypeId = CustomerType::where('customer_type_name', 'Residential')->first()->customer_type_id;
        $businessTypeId = CustomerType::where('customer_type_name', 'Business')->first()->customer_type_id;

        // Create 5 of each type of customer for each town, faker will generate a random phone number and name which is in the factory file
        Customer::factory()->count(5)->create([
            'town_id' => $negrilTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $stAnnsBayTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $mandevilleTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $oldHarborTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $stJagoTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $bridgeportTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $dumfriesTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $barbicanTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $independenceCityTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 5 Business Customers
        Customer::factory()->count(5)->create([
            'town_id' => $negrilTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $stAnnsBayTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $mandevilleTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $oldHarborTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
           'town_id' => $stJagoTownId,
           'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $bridgeportTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $dumfriesTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $barbicanTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(5)->create([
           'town_id' => $independenceCityTownId,
           'customer_type_id' => $businessTypeId,
        ]);   
        
    }
}
