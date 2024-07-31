<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OLT;
use App\Models\Customer;
use App\Models\Resource;

class OLTSeeder extends Seeder
{
    public function run()
    {
        $resources = Resource::all();
        
        $olts = [
            ['olt_name' => 'OLT Negril', 'parish_id' => 1, 'town_id' => 1, 'rank' => 6],
            ['olt_name' => 'OLT St. Anns Bay', 'parish_id' => 4, 'town_id' => 4, 'rank' => 9],
            ['olt_name' => 'OLT Mandeville', 'parish_id' => 5, 'town_id' => 5, 'rank' => 8],
            ['olt_name' => 'OLT Old Harbor', 'parish_id' => 2, 'town_id' => 6, 'rank' => 7],
            ['olt_name' => 'OLT St. Jago', 'parish_id' => 2, 'town_id' => 7, 'rank' => 3],
            ['olt_name' => 'OLT Bridgeport', 'parish_id' => 2, 'town_id' => 8, 'rank' => 2],
            ['olt_name' => 'OLT Dumfries', 'parish_id' => 3, 'town_id' => 9, 'rank' => 1],
            ['olt_name' => 'OLT Barbican', 'parish_id' => 3, 'town_id' => 3, 'rank' => 4],
            ['olt_name' => 'OLT Independence City', 'parish_id' => 2, 'town_id' => 2, 'rank' => 5],
        ];

        foreach ($olts as $oltData) {
            // Create a new OLT instance
            $olt = new OLT();
            $olt->olt_name = $oltData['olt_name'];
            $olt->parish_id = $oltData['parish_id'];
            $olt->town_id = $oltData['town_id'];
            $olt->rank = $oltData['rank']; // Ensure the rank is assigned correctly

            // Calculate customer counts and value
            $customers = Customer::where('town_id', $olt->town_id)->get();
            $olt->customer_count = $customers->count();
            $olt->business_customer_count = $customers->where('customer_type_id', 2)->count();
            $olt->residential_customer_count = $customers->where('customer_type_id', 1)->count();

            $businessValue = $customers->where('customer_type_id', 2)->count() * 1200;
            $residentialValue = $customers->where('customer_type_id', 1)->count() * 32;
            $olt->olt_value = $businessValue + $residentialValue;

            // Calculate level
            $olt->level = ($olt->business_customer_count >= 800) ? 'High' : 'Low';

            // Assign a random resource
            $olt->resource_id = $resources->random()->resource_id;

            $olt->save();
        }
    }
}
