<?php
namespace App\Http\Controllers;

use App\Models\OLT;
use App\Models\Team;
use App\Models\OutageHistory;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOutages = OutageHistory::count();
        $ongoingOutages = OutageHistory::where('status', 1)->count();
        $stats = [
            'totalOlts' => OLT::count(),
            'totalTeams' => Team::count(),
            'totalOutages' => $totalOutages,
            'ongoingOutages' => $ongoingOutages,
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

