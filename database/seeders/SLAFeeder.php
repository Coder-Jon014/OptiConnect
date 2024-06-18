<?php

// database/seeders/SLASeeder.php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\SLA;
use App\Models\OutageHistory;
use App\Models\OLT;
use App\Models\Customer;

class SLASeeder extends Seeder
{
    public function run()
    {
        $outageHistories = OutageHistory::all();

        foreach ($outageHistories as $outage) {
            $olt = OLT::find($outage->olt_id);
            $businessCustomers = Customer::where('location_id', $olt->town_id)
                                          ->where('customer_type_id', 2)
                                          ->count();
            $residentialCustomers = Customer::where('location_id', $olt->town_id)
                                             ->where('customer_type_id', 1)
                                             ->count();

            $maxDuration = $outage->duration / 3600; // Convert duration from seconds to hours

            if ($businessCustomers > 0 && $maxDuration > 24) {
                $compensationDetails = 'Refund';
            } elseif ($residentialCustomers > 0 && $maxDuration > 72) {
                $compensationDetails = 'Refund';
            } else {
                $compensationDetails = 'Don\'t Refund';
            }

            SLA::create([
                'customer_type_id' => $businessCustomers > 0 ? 2 : 1, // 2 for Business, 1 for Residential
                'max_duration' => $maxDuration,
                'compensation_details' => $compensationDetails,
                'outage_history_id' => $outage->id, // Assuming you want to link SLA to outage history
            ]);
        }
    }
}
