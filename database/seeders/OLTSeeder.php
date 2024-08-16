<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OLT;
use App\Models\Customer;
use App\Models\Resource;
use Illuminate\Support\Facades\Log;

class OLTSeeder extends Seeder
{
    public function run()
    {
        $olts = [
            ['olt_name' => 'OLT Negril', 'parish_id' => 1, 'town_id' => 1, 'resource_id' => 1], // Assuming 1 is the ID for Bucket-Truck
            ['olt_name' => 'OLT St. Anns Bay', 'parish_id' => 4, 'town_id' => 4, 'resource_id' => 2], // Assuming 2 is the ID for PPE
            ['olt_name' => 'OLT Mandeville', 'parish_id' => 5, 'town_id' => 5, 'resource_id' => null],
            ['olt_name' => 'OLT Old Harbor', 'parish_id' => 2, 'town_id' => 6, 'resource_id' => null],
            ['olt_name' => 'OLT St. Jago', 'parish_id' => 2, 'town_id' => 7, 'resource_id' => 1], // Bucket-Truck
            ['olt_name' => 'OLT Bridgeport', 'parish_id' => 2, 'town_id' => 8, 'resource_id' => null],
            ['olt_name' => 'OLT Dumfries', 'parish_id' => 3, 'town_id' => 9, 'resource_id' => 3], // Assuming 3 is the ID for Bucket-Van
            ['olt_name' => 'OLT Barbican', 'parish_id' => 3, 'town_id' => 3, 'resource_id' => 3], // Bucket-Van
            ['olt_name' => 'OLT Independence City', 'parish_id' => 2, 'town_id' => 2, 'resource_id' => 1], // Bucket-Truck
        ];        

        foreach ($olts as $oltData) {
            // Create a new OLT instance
            $olt = new OLT();
            $olt->olt_name = $oltData['olt_name'];
            $olt->parish_id = $oltData['parish_id'];
            $olt->town_id = $oltData['town_id'];

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

            // Assign the specified resource ID
            $olt->resource_id = $oltData['resource_id'];

            $olt->save();

            Log::info('OLT Created', [
                'olt_name' => $olt->olt_name,
                'resource_id' => $olt->resource_id
            ]);
        }
    }
}