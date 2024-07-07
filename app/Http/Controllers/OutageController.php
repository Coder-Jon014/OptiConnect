<?php

namespace App\Http\Controllers;

use App\Models\OutageHistory;
use App\Http\Requests\StoreOutageHistoryRequest;
use App\Http\Requests\UpdateOutageHistoryRequest;
use App\Http\Resources\OutageResource;
use App\Models\OLT;
use App\Models\Team;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;


class OutageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = OutageHistory::query(); // Get all outages
        $sortField = request("sort_field", "start_time");
        $sortDirection = request("sort_direction", "asc");
    
        if (request("olt")){
            $query->whereHas('olt', function($q) {
                $q->where('olt_name', 'LIKE', '%' . request('olt') . '%');
            });
        }
        if (request("team")) {
            $query->whereHas('team', function($q) {
                $q->where('team_name', 'LIKE', '%' . request('team') . '%');
            });
        }
    
        // Handle sorting fields
        if ($sortField === 'olt') {
            $query->join('olts', 'outage_histories.olt_id', '=', 'olts.olt_id')
                  ->select('outage_histories.*')
                  ->orderBy('olts.olt_name', $sortDirection);
        } elseif ($sortField === 'team') {
            $query->join('teams', 'outage_histories.team_id', '=', 'teams.team_id')
                  ->select('outage_histories.*')
                  ->orderBy('teams.team_name', $sortDirection);
        } else {
            $query->orderBy($sortField, $sortDirection);
        }
    
        // Paginate outages
        $outages = $query->paginate(10)->onEachSide(1);
    
        return inertia('Outages/Index', [
            "outages" => OutageResource::collection($outages),
            'queryParams' => request()->query() ?: null,
        ]);
    }
    

    /**
     * Generate a live outage
     */
    public function generateOutage(Request $request)
    {
        $olt = OLT::inRandomOrder()->first();

        if (!$olt) {
            return response()->json(['message' => 'No OLT found'], 404);
        }

        $resourceId = $olt->resource_id;

        $team = Team::whereHas('resources', function ($query) use ($resourceId) {
            $query->where('resources.resource_id', $resourceId);
        })->where('status', 0)->first();

        if (!$team) {
            return response()->json(['message' => 'No team available'], 404);
        }

        $outage = new OutageHistory();
        $outage->olt_id = $olt->olt_id;
        $outage->team_id = $team->team_id;
        $outage->start_time = now();
        $outage->status = true;
        $outage->save();

        $team->status = true;
        $team->save();

        return Redirect::back()->with('success', 'Outage generated successfully');
    }

    /**
     * Stop a live outage
     */
    public function stopAllOutages(Request $request)
    {
        // Fetch all ongoing outages
        $ongoingOutages = OutageHistory::where('status', true)->get();
    
        // Iterate through each ongoing outage and update its status
        foreach ($ongoingOutages as $outage) {
            $outage->end_time = now();
            $outage->duration = $outage->end_time->diffInSeconds($outage->start_time);
            $outage->status = false;
            $outage->save();
    
            // Update the status of the team assigned to this outage
            $team = Team::find($outage->team_id);
            if ($team) {
                $team->status = false;
                $team->save();
            }
        }
    
        return Redirect::back()->with('success', 'All outages stopped successfully');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutageHistoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OutageHistory $outageHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OutageHistory $outageHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutageHistoryRequest $request, OutageHistory $outageHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutageHistory $outageHistory)
    {
        //
    }
}
