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
        // Initialize the query
        $query = OutageHistory::with('olt', 'team', 'sla'); // Get all outages with related models

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
        // Find an OLT with customers
        $olt = OLT::where('customer_count', '>', 0)->inRandomOrder()->first();

        if (!$olt) {
            return response()->json(['message' => 'No OLT with customers found'], 404);
        }

        $resourceId = $olt->resource_id; // Get the resource ID of the OLT basically checking for the resource this OLT has

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

        // Send SMS to customers
        $this->sendOutageNotifications($olt);

        return Redirect::back()->with('success', 'Outage generated successfully');
    }

    /**
     * Send outage notifications to customers
     */
    private function sendOutageNotifications($olt)
{
    // List of verified numbers
    $verifiedNumbers = [
        '+1234567890',
        '+1987654321',
        // Add more verified numbers here
    ];

    // Fetch customers for the OLT
    $customers = Customer::where('town_id', $olt->town_id)->get();

    $accountSid = env('TWILIO_ACCOUNT_SID');
    $authToken = env('TWILIO_AUTH_TOKEN');
    $twilioNumber = env('TWILIO_PHONE_NUMBER');
    $client = new Client($accountSid, $authToken);

    \Log::info("Twilio SID: $accountSid");
    \Log::info("Twilio Auth Token: $authToken");
    \Log::info("Twilio Number: $twilioNumber");

    foreach ($customers as $customer) {
        // Check if the customer's number is in the verified list
        if (!in_array($customer->telephone, $verifiedNumbers)) {
            \Log::info("Skipping unverified number: {$customer->telephone}");
            continue;
        }

        $message = "Dear customer {$customer->customer_name}, we are currently experiencing an outage at {$olt->olt_name}. Our team is working on it.";
        $client->messages->create(
            $customer->telephone,
            [
                'from' => $twilioNumber,
                'body' => $message,
            ]
        );
        // Log the message sent
        \Log::info("Message sent to {$customer->telephone}");
    }
}


    public function stopAllOutages(Request $request)
{
    // Fetch all ongoing outages
    $ongoingOutages = OutageHistory::where('status', true)->get();

    // Iterate through each ongoing outage and update its status
    foreach ($ongoingOutages as $outage) {
        $endTime = now();
        $startTime = new \DateTime($outage->start_time);
        
        // Ensure that the duration calculation is correct
        $duration = $endTime->getTimestamp() - $startTime->getTimestamp();
        
        $outage->end_time = $endTime;
        $outage->duration = $duration;
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
        // Log the request
        Log::info("Request received for outage teams with OLT resource");
        Log::info("Outage ID: {$request->input('outage_id')}");
        
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

        //Just log the teams
        Log::info("Teams with OLT Resource ID: {$teams}");
        Log::info("Outage ID: {$outage}");
    
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
