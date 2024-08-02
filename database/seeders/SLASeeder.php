<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SLA;
use App\Models\OutageHistory;
use App\Models\CustomerType;
use App\Models\OLT;
use App\Models\Customer;

class SLASeeder extends Seeder
{
    public function run()
    {
        $outageHistories = OutageHistory::all();

        foreach ($outageHistories as $outage) {
            $olt = OLT::find($outage->olt_id);

            if ($olt) { // Ensure OLT exists
                $businessCustomers = Customer::where('town_id', $olt->town_id)
                                             ->where('customer_type_id', 2)
                                             ->count();
                $residentialCustomers = Customer::where('town_id', $olt->town_id)
                                                ->where('customer_type_id', 1)
                                                ->count();

                // Convert duration to hours and round to the nearest two decimal places
                $maxDuration = round($outage->duration / 3600);
                //24

                if ($businessCustomers > 0 && $maxDuration >= 24) {
                    $compensationDetails = 'Refund';
                } elseif ($residentialCustomers > 0 && $maxDuration >= 72) {
                    $compensationDetails = 'Refund';
                } else {
                    $compensationDetails = 'No Refund';
                }

                // Get team assigned to outage
                $teamAssignedToOutage = $outage->team_id;

                // Process SLA for refund calculation
                if ($compensationDetails == 'Refund') {
                    $outageDurationDays = round($maxDuration / 24); // Convert duration from hours to days
                    $residentialRefund = ($outageDurationDays / 30) * 32 * $residentialCustomers;
                    $businessRefund = ($outageDurationDays / 30) * 1200 * $businessCustomers;
                    $refundAmount = $residentialRefund + $businessRefund;
                    $resolutionDetails = 'Outage was not resolved within the SLA';
                } else {
                    $refundAmount = 0.00;
                    $resolutionDetails = 'Outage was resolved within the SLA';
                }

                // Update Outage Resolution Details
                $outage->update(['resolution_details' => $resolutionDetails]);

                // Create the SLA record
                SLA::create([
                    'customer_type_id' => $businessCustomers > 0 ? 2 : 1, // 2 for Business, 1 for Residential
                    'max_duration' => $maxDuration,
                    'compensation_details' => $compensationDetails,
                    'outage_history_id' => $outage->id, // Link SLA to outage history
                    'refund_amount' => $refundAmount,
                    'team_id' => $teamAssignedToOutage,
                ]);
            }
        }
    }
}
