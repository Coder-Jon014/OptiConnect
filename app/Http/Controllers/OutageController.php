<?php

namespace App\Http\Controllers;

use App\Models\OutageHistory;
use App\Http\Resources\OutageResource;
use App\Http\Resources\TeamResource;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redirect;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OutagesExport;
use Twilio\Rest\Client;
use App\Models\OLT;
use App\Models\Team;
use App\Models\Customer;
use Illuminate\Support\Facades\Log;

class OutageController extends Controller
{
    public function index(Request $request)
    {
        // Initialize the query with necessary relationships and select specific columns
        $query = OutageHistory::query()
            ->with([
                'olt:olt_id,olt_name', 
                'team:team_id,team_name,team_type', 
                'sla:id,outage_history_id,refund_amount'
            ])
            ->select('outage_histories.*');
    
        // Sorting fields
        $sortField = $request->input('sort_field', 'start_time');
        $sortDirection = $request->input('sort_direction', 'desc');
    
        // Filtering by OLT
        if ($request->input('olt')) {
            $query->whereHas('olt', function($q) use ($request) {
                $q->where('olt_name', 'LIKE', '%' . $request->input('olt') . '%');
            });
        }
    
        // Filtering by Team
        if ($request->input('team')) {
            $query->whereHas('team', function($q) use ($request) {
                $q->where('team_name', 'LIKE', '%' . $request->input('team') . '%');
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
        $teams = TeamResource::collection(Team::all());
    
        return Inertia::render('Outages/Index', [
            "teams" => $teams,
            "outages" => OutageResource::collection($outages),
            'queryParams' => $request->query() ?: null,
        ]);
    }
        
    


public function generateOutage(Request $request)
{
    $olt = OLT::where('customer_count', '>', 0)->inRandomOrder()->first();

    if (!$olt) {
        return response()->json(['message' => 'No OLT with customers found'], 404);
    }

    $resourceId = $olt->resource_id;

    $team = Team::whereHas('resources', function ($query) use ($resourceId) {
        $query->where('resources.resource_id', $resourceId);
    })->where('status', 0)->first();

    if (!$team) {
        return response()->json(['message' => 'No team available'], 404);
    }

    $outage = OutageHistory::create([
        'olt_id' => $olt->olt_id,
        'team_id' => $team->team_id,
        'start_time' => now(),
        'status' => true,
    ]);

    $team->update(['status' => true]);

    $this->sendOutageNotifications($olt);

    return Redirect::back()->with('success', 'Outage generated successfully');
}


private function sendOutageNotifications($olt)
{
    $verifiedNumbers = [
        '18762922254',
        '18765528469',
        '18764653933',
        '18763477662',
    ];

    $customers = Customer::where('town_id', $olt->town_id)
                        ->whereIn('telephone', $verifiedNumbers)
                        ->get();

    $accountSid = env('TWILIO_ACCOUNT_SID');
    $authToken = env('TWILIO_AUTH_TOKEN');
    $twilioNumber = env('TWILIO_PHONE_NUMBER');
    $client = new Client($accountSid, $authToken);

    foreach ($customers as $customer) {
        $message = "Dear customer {$customer->customer_name}, we are currently experiencing an outage at {$olt->olt_name}. Our team is working on it.";
        $client->messages->create(
            $customer->telephone,
            [
                'from' => $twilioNumber,
                'body' => $message,
            ]
        );
    }
}



public function stopAllOutages(Request $request)
{
    $ongoingOutages = OutageHistory::where('status', true)->get();

    foreach ($ongoingOutages as $outage) {
        $endTime = now();
        $duration = $endTime->getTimestamp() - (new \DateTime($outage->start_time))->getTimestamp();

        $outage->update([
            'end_time' => $endTime,
            'duration' => $duration,
            'status' => false,
        ]);

        if ($outage->team) {
            $outage->team->update(['status' => false]);
        }
    }

    return Redirect::back()->with('success', 'All outages stopped successfully');
}

    public function generateOutageReport()
    {
        return Excel::download(new OutagesExport, 'outages_report.xlsx');
        
    }

    private function createOutageReport($outages)
    {
        $pdf = PDF::loadView('outage-report', ['outages' => $outages]);
        $path = storage_path('app/public/reports/OutageReport.pdf');
        $pdf->save($path);
        return $path;
    }

    public function teamsWithOLTResource(Request $request)
    {
        // Validate the outage_id
        $request->validate([
            'outage_id' => 'required|exists:outage_histories,id',
        ]);
    
        // Find the outage
        $outage = OutageHistory::find($request->input('outage_id'));
    
        if (!$outage) {
            return response()->json(['error' => 'Outage not found'], 404);
        }
    
        // Find the OLT related to the outage
        $olt = OLT::find($outage->olt_id);
    
        if (!$olt) {
            return response()->json(['error' => 'OLT not found'], 404);
        }
    
        // Retrieve teams with resources matching the OLT's resource_id
        $teams = Team::whereHas('resources', function ($query) use ($olt) {
            $query->where('resources.resource_id', $olt->resource_id);
        })->get();

        return response()->json([
            'teams' => TeamResource::collection($teams),
            'outage' => new OutageResource($outage),
        ]);
    }
    





    public function reassignTeam(Request $request)
    {
        $request->validate([
            'outage_id' => 'required|exists:outage_histories,id',
            'team_id' => 'required|exists:teams,team_id',
        ]);

        $outage = OutageHistory::find($request->outage_id);
        $newTeam = Team::find($request->team_id);

        if ($outage && $newTeam) {
            // Set the current team to inactive
            $currentTeam = Team::find($outage->team_id);
            if ($currentTeam) {
                $currentTeam->status = false;
                $currentTeam->save();
            }

            // Assign the new team
            $outage->team_id = $newTeam->team_id;
            $outage->save();

            // Set the new team to active
            $newTeam->status = true;
            $newTeam->save();
        }

        return Redirect::back()->with('success', 'Team reassigned successfully');
    }

}
