<?php

namespace App\Http\Controllers;

use App\Models\SLA;
use App\Models\Customer;
use App\Models\OLT;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SLAController extends Controller
{
    public function index(Request $request)
    {
        // Retrieve paginated SLAs with necessary relationships
        $slas = SLA::with('customerType', 'outageHistory.olt')->paginate(10);

        // Process each SLA for refund calculation
        foreach ($slas as $sla) {
            if ($sla->compensation_details == 'Refund') {
                $outage = $sla->outageHistory;
                $olt = $outage->olt;

                if ($olt) {
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

                    // Process SLA for refund calculation
                    if ($compensationDetails == 'Refund') {
                        $outageDurationDays = round($maxDuration / 24); // Convert duration from hours to days
                        $residentialRefund = ($outageDurationDays / 30) * 32 * $residentialCustomers;
                        $businessRefund = ($outageDurationDays / 30) * 1200 * $businessCustomers;
                        $sla->refund_amount = $residentialRefund + $businessRefund;
                    } else {
                        $sla->refund_amount = 0;
                    }
                } else {
                    $sla->refund_amount = 0;
                }
            } else {
                $sla->refund_amount = 0;
            }
        }

        // Transform SLAs to resources for the frontend
        $slasTransformed = $slas->getCollection()->map(function($sla) {
            return [
                'id' => $sla->id,
                'customer_type' => $sla->customerType->customer_type_name,
                'max_duration' => $sla->max_duration,
                'compensation_details' => $sla->compensation_details,
                'refund_amount' => $sla->refund_amount,
            ];
        });

        // Return the Inertia response with the paginated data
        return Inertia::render('SLAs/Index', [
            'slas' => [
                'data' => $slasTransformed,
                'links' => $slas->linkCollection(),
            ],
            'queryParams' => $request->query() ?: null,
        ]);
    }
}
