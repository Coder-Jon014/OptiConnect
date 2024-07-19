<?php

namespace App\Http\Controllers;

use App\Models\OLT;
use App\Models\SLA;
use App\Models\Team;
use App\Models\Customer;
use App\Models\OutageHistory;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOutages = OutageHistory::count();
        $ongoingOutages = OutageHistory::where('status', 1)->count();

        // Fetch all OLTs
        $olts = OLT::all();

        // Calculate total OLT customers
        $totalOLTCustomers = $olts->sum('residential_customer_count') + $olts->sum('business_customer_count');

        // Calculate refunds
        $slaRecords = SLA::with(['outageHistory.olt', 'customerType'])->get();
        $totalRefund = 0;

        foreach ($slaRecords as $sla) {
            if ($sla->compensation_details === 'Refund') {
                $durationInDays = $sla->outageHistory->duration / 86400; // Convert seconds to days
                $olt = $sla->outageHistory->olt;

                if ($sla->customerType->customer_type_name === 'Residential') {
                    $refundAmount = ($durationInDays / 30) * $olt->residential_customer_value * $olt->residential_customer_count;
                } else if ($sla->customerType->customer_type_name === 'Business') {
                    $refundAmount = ($durationInDays / 30) * $olt->business_customer_value * $olt->business_customer_count;
                }

                $totalRefund += $refundAmount;
            }
        }

        $stats = [
            'totalOlts' => OLT::count(),
            'totalTeams' => Team::count(),
            'totalOutages' => $totalOutages,
            'ongoingOutages' => $ongoingOutages,
            'totalRefund' => $totalRefund,
            'totalOLTCustomers' => $totalOLTCustomers,
        ];

        $allOutages = OutageHistory::with('olt', 'team')->get();
        $recentOutages = OutageHistory::with('olt', 'team')->latest()->take(5)->get();
        $teamStatus = Team::with('resources')->get();

        // Prepare OLT data for the chart
        $oltData = $olts->map(function ($olt) {
            return [
                'olt' => $olt->olt_name,
                'customer_count' => $olt->business_customer_count + $olt->residential_customer_count,
                'business_customer_count' => $olt->business_customer_count,
                'residential_customer_count' => $olt->residential_customer_count,
            ];
        });

        // Fetch customers data
        $customers = Customer::with('olt')->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentOutages' => $recentOutages,
            'teamStatus' => $teamStatus,
            'customers' => $customers,
            'oltData' => $oltData,
        ]);
    }
}
