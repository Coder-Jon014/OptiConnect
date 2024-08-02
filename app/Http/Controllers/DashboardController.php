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
        ini_set('memory_limit', '1024M');

        $totalOutages = OutageHistory::count();
        $ongoingOutages = OutageHistory::where('status', 1)->count();

        // Fetch all OLTs with necessary relationships
        $olts = OLT::with(['outages', 'customers'])->get();

        // Calculate total OLT customers
        $totalOLTCustomers = $olts->sum('residential_customer_count') + $olts->sum('business_customer_count');

        // Calculate refunds
        $slaRecords = SLA::with(['outageHistory.olt', 'customerType'])->get();
        $totalRefund = 0;
        $totalNoRefund = 0;

        

        foreach ($slaRecords as $sla) {
            // sum up refund amount for each SLA
             $totalRefund += $sla->refund_amount;

             if ($sla->compensation_details == 'No Refund') {
                 $totalNoRefund += 1;
             }
        }

        // Calculate number of times a team has been assigned to an outage
        $numberofTimeTeamdeployed = SLA::groupBy('team_id')
        ->selectRaw('team_id, COUNT(*) as timesDeployed')
        ->get()
        ->toArray();

        

        //Days since last outage, first check if there is an ongoing outage
        if ($ongoingOutages) {
            $durationInDays = 0;
        } else {
            // Find the most recent resolved outage
            $lastResolvedOutage = OutageHistory::where('status', false)->latest()->first();
            
            if ($lastResolvedOutage) {
                // Calculate days since the last resolved outage, rounding down to nearest day
                $durationInDays = floor((time() - $lastResolvedOutage->created_at->timestamp) / 86400);
            } else {
                $durationInDays = 0;
            }
        }

        // Collect stats
        $stats = [
            'totalOlts' => $olts->count(),
            'totalTeams' => Team::count(),
            'totalOutages' => $totalOutages,
            'ongoingOutages' => $ongoingOutages,
            'totalRefund' => $totalRefund,
            'totalOLTCustomers' => $totalOLTCustomers,
            'daysSinceLastOutage' => $durationInDays,
            'totalNoRefund' => $totalNoRefund,
            'numberofTimeTeamdeployed' => $numberofTimeTeamdeployed,
        ];

        // Fetch outages with necessary relationships
        $allOutages = OutageHistory::with(['olt', 'team'])->get();
        $recentOutages = OutageHistory::with(['olt', 'team'])->latest()->take(5)->get();
        $teamStatus = Team::with('resources')->get();

        // Prepare OLT data for the chart
        $oltData = $olts->map(function ($olt) {
            return [
                'olt' => $olt->olt_name,
                'customer_count' => $olt->business_customer_count + $olt->residential_customer_count,
                'business_customer_count' => $olt->business_customer_count,
                'residential_customer_count' => $olt->residential_customer_count,
                'olt_value' => $olt->olt_value,
            ];
        });

        // Fetch customers data with necessary relationships
        $customers = Customer::with('olt')->get();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'recentOutages' => $recentOutages,
            'teamStatus' => $teamStatus,
            // 'customers' => $customers,
            'oltData' => $oltData,
        ]);
    }
}
