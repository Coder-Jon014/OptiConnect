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
            ['olt_name' => 'OLT Negril', 'parish_id' => 1, 'town_id' => 1],
            ['olt_name' => 'OLT St. Anns Bay', 'parish_id' => 4, 'town_id' => 2],
            ['olt_name' => 'OLT Mandeville', 'parish_id' => 5, 'town_id' => 3],
            ['olt_name' => 'OLT Old Harbor', 'parish_id' => 2, 'town_id' => 4],
            ['olt_name' => 'OLT St. Jago', 'parish_id' => 2, 'town_id' => 5],
            ['olt_name' => 'OLT Bridgeport', 'parish_id' => 2, 'town_id' => 6],
            ['olt_name' => 'OLT Dumfries', 'parish_id' => 3, 'town_id' => 7],
            ['olt_name' => 'OLT Barbican', 'parish_id' => 3, 'town_id' => 8],
            ['olt_name' => 'OLT Independence City', 'parish_id' => 2, 'town_id' => 9],
        ];

        foreach ($olts as $oltData) {
            $olt = new OLT($oltData);

            // Calculate customer counts and value
            $customers = Customer::where('town_id', $olt->town_id)->get();
            $olt->customer_count = $customers->count();
            $olt->business_customer_count = $customers->where('customer_type_id', 2)->count();
            $olt->residential_customer_count = $customers->where('customer_type_id', 1)->count();

            $businessValue = $customers->where('customer_type_id', 2)->count() * 1200;
            $residentialValue = $customers->where('customer_type_id', 1)->count() * 32;
            $olt->olt_value = $businessValue + $residentialValue;

            // Calculate rank
            if ($olt->customer_count <= 5000) {
                $olt->rank = 5;
            } elseif ($olt->customer_count <= 10000) {
                $olt->rank = 4;
            } elseif ($olt->customer_count <= 15000) {
                $olt->rank = 3;
            } elseif ($olt->customer_count <= 20000) {
                $olt->rank = 2;
            } else {
                $olt->rank = 1;
            }

            // Calculate level
            if ($olt->business_customer_count >= 1000) {
                $olt->level = 'High';
            } else {
                $olt->level = 'Low';
            }

            // Assign a random resource
            $olt->resource_id = $resources->random()->resource_id;

            $olt->save();
        }
    }
}
