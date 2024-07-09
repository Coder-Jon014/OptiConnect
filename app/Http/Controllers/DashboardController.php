<?php

namespace App\Http\Controllers;

use App\Models\OLT;
use App\Models\SLA;
use App\Models\Team;
use App\Models\OutageHistory;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOutages = OutageHistory::count();
        $ongoingOutages = OutageHistory::where('status', 1)->count();

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
        ];

        $recentOutages = OutageHistory::with('olt', 'team')->latest()->take(5)->get();
        $teamStatus = Team::with('resources')->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentOutages' => $recentOutages,
            'teamStatus' => $teamStatus,
        ]);
    }
}
