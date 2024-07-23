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
        $oldHarborTownId = 6;
        $stJagoTownId = 7;
        $bridgeportTownId = 8;
        $dumfriesTownId = 9;
        $barbicanTownId = 3;
        $independenceCityTownId = 2;

        $residentialTypeId = CustomerType::where('customer_type_name', 'Residential')->first()->customer_type_id;
        $businessTypeId = CustomerType::where('customer_type_name', 'Business')->first()->customer_type_id;

        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $negrilTownId,
            'telephone' => '+18762922254',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $stAnnsBayTownId,
            'telephone' => '+18762922254',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $mandevilleTownId,
            'telephone' => '+18762922254',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $oldHarborTownId,
            'telephone' => '+18762922254',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $stJagoTownId,
            'telephone' => '+18762922254',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $barbicanTownId,
            'telephone' => '+18762922254',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $dumfriesTownId,
            'telephone' => '+18762922254',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Jon',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $independenceCityTownId,
            'telephone' => '+18762922254',
        ]);
        //
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $negrilTownId,
            'telephone' => '+18765528469',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $stAnnsBayTownId,
            'telephone' => '+18765528469',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $mandevilleTownId,
            'telephone' => '+18765528469',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $oldHarborTownId,
            'telephone' => '+18765528469',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $stJagoTownId,
            'telephone' => '+18765528469',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $barbicanTownId,
            'telephone' => '+18765528469',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $dumfriesTownId,
            'telephone' => '+18765528469',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Howard',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $independenceCityTownId,
            'telephone' => '+18762922254',
        ]);
        //
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $negrilTownId,
            'telephone' => '+18764653933',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $stAnnsBayTownId,
            'telephone' => '+18764653933',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $mandevilleTownId,
            'telephone' => '+18764653933',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $oldHarborTownId,
            'telephone' => '+18764653933',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $stJagoTownId,
            'telephone' => '+18764653933',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $barbicanTownId,
            'telephone' => '+18764653933',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $dumfriesTownId,
            'telephone' => '+18764653933',
        ]);
        Customer::factory()->create([
            'customer_name' => 'Gareth',
            'customer_type_id' => $residentialTypeId,
            'town_id' => $independenceCityTownId,
            'telephone' => '+18764653933',
        ]);
        // Create 5 of each type of customer for each town, faker will generate a random phone number and name which is in the factory file
        // Customer::factory()->count(22)->create([
        //     'town_id' => $negrilTownId,
        //     'customer_type_id' => $residentialTypeId,
        // ]);
        Customer::factory()->count(58)->create([
            'town_id' => $stAnnsBayTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(12)->create([
            'town_id' => $mandevilleTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(4)->create([
            'town_id' => $oldHarborTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $stJagoTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(1)->create([
            'town_id' => $bridgeportTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(5)->create([
            'town_id' => $dumfriesTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(3)->create([
            'town_id' => $barbicanTownId,
            'customer_type_id' => $residentialTypeId,
        ]);
        Customer::factory()->count(12)->create([
            'town_id' => $independenceCityTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

        // Create 5 Business Customers
        Customer::factory()->count(23)->create([
            'town_id' => $negrilTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(87)->create([
            'town_id' => $stAnnsBayTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(15)->create([
            'town_id' => $mandevilleTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(25)->create([
            'town_id' => $oldHarborTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(32)->create([
           'town_id' => $stJagoTownId,
           'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(32)->create([
            'town_id' => $bridgeportTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(25)->create([
            'town_id' => $dumfriesTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(51)->create([
            'town_id' => $barbicanTownId,
            'customer_type_id' => $businessTypeId,
        ]);
        Customer::factory()->count(25)->create([
           'town_id' => $independenceCityTownId,
           'customer_type_id' => $businessTypeId,
        ]);   
        
    }
}
