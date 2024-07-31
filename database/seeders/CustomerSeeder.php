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

        Customer::factory()->count(1100)->create([
            'town_id' => $barbicanTownId,
            'customer_type_id' => $residentialTypeId,
        ]);

    }
}
