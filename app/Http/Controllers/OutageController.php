<?php

namespace App\Http\Controllers;

use App\Models\OutageHistory;
use App\Http\Resources\OutageResource;
use App\Http\Resources\OLTResource;
use App\Http\Resources\OutageTypesResource;
use App\Http\Resources\TeamResource;
use Inertia\Inertia;
use Carbon\Carbon;
use Redirect;
use App\Exports\OutagesExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\Models\OLT;
use App\Models\Team;
use App\Models\Customer;
use App\Models\SLA;
use App\Models\OutageTypes;
use Illuminate\Support\Facades\Log;

class OutageController extends Controller
{
    public function index(Request $request)
    {
        // Initialize the query with necessary relationships and select specific columns
        $query = OutageHistory::query()
            ->with([
                'olt:olt_id,olt_name', 
                'team:team_id,team_name,team_type,deployment_cost', 
                'sla:id,outage_history_id,refund_amount',
                'outageType:outage_type_id,outage_type_name,resource_id'
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

        // Filtering by Outage Type
        if ($request->input('outage_type')) {
            $query->whereHas('outageType', function($q) use ($request) {
                $q->where('outage_type_name', 'LIKE', '%' . $request->input('outage_type') . '%');
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
        } elseif ($sortField === 'outage_type') {
            $query->join('outage_types', 'outage_histories.outage_type_id', '=', 'outage_types.outage_type_id')
                  ->select('outage_histories.*')
                  ->orderBy('outage_types.outage_type_name', $sortDirection);
        } elseif ($sortField === 'deployment_cost') {
            $query->join('teams', 'outage_histories.team_id', '=', 'teams.team_id')
                  ->select('outage_histories.*')
                  ->orderBy('teams.deployment_cost', $sortDirection);
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



    private function calculateAndSaveSLA($outage)
    {
        $olt = OLT::find($outage->olt_id);
        $businessRefund = false;
        $residentialRefund = false;

        if ($olt) { // Ensure OLT exists
            $businessCustomers = Customer::where('town_id', $olt->town_id)
                                        ->where('customer_type_id', 2)
                                        ->count();
            $residentialCustomers = Customer::where('town_id', $olt->town_id)
                                            ->where('customer_type_id', 1)
                                            ->count();

           // Convert duration to hours and round to the nearest whole number
            $maxDuration = round($outage->duration / 3600);

            // Get team assigned to outage
            $teamAssignedToOutage = $outage->team_id;

            // Initialize refund variables
            $businessRefund = false;
            $residentialRefund = false;
            $BizRefund = 0.00;
            $ResRefund = 0.00;

            if ($businessCustomers > 0 && $maxDuration >= 24) {
                $businessRefund = true;
                if ($maxDuration >= 72) {
                    $residentialRefund = true;
                }
            }

            if ($businessRefund || $residentialRefund) {
                $compensationDetails = 'Refund';
                $outageDurationDays = round($maxDuration / 24); // Convert duration from hours to days
                
                if ($businessRefund) {
                    $BizRefund = ($outageDurationDays / 30) * 1200 * $businessCustomers;
                }
                
                if ($residentialRefund) {
                    $ResRefund = ($outageDurationDays / 30) * 32 * $residentialCustomers;
                }
                
                $refundAmount = $BizRefund + $ResRefund;
                $resolutionDetails = 'Outage was not resolved within the SLA';
            } else {
                $compensationDetails = 'No Refund';
                $refundAmount = 0.00;
                $resolutionDetails = 'Outage was resolved within the SLA';
            }


            //Update Outage Resolution Details
            $outage->update(['resolution_details' => $resolutionDetails]);

            // // Update the SLA record
            // $sla = SLA::where('outage_history_id', $outage->id)->first();
            // $sla->update([
            //     'max_duration' => $maxDuration,
            //     'compensation_details' => $compensationDetails,
            //     'refund_amount' => $refundAmount,
            //     'team_id' => $teamAssignedToOutage,
            // ]);

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


    public function generateOutage(Request $request)
    {
        $maxAttempts = 10; // Limit the number of attempts to prevent infinite loops
        $attempts = 0;

        do {
            // Select a random OLT with customers
            $olt = OLT::where('customer_count', '>', 0)->inRandomOrder()->first();

            if (!$olt) {
                return response()->json(['message' => 'No OLT with customers found'], 404);
            }

            // Check if the OLT has an active outage
            $activeOutage = OutageHistory::where('olt_id', $olt->olt_id)->where('status', true)->exists();

            $attempts++;
        } while ($activeOutage && $attempts < $maxAttempts);

        if ($activeOutage) {
            return response()->json(['message' => 'Unable to find an OLT without an active outage'], 404);
        }

        // Select a random outage type
        $outageType = OutageTypes::inRandomOrder()->first();

        if (!$outageType) {
            return response()->json(['message' => 'No outage types found'], 404);
        }

        // Create the outage
        $outage = OutageHistory::create([
            'olt_id' => $olt->olt_id,
            'outage_type_id' => $outageType->outage_type_id,
            'start_time' => now(),
            'status' => true, // true indicates an active outage
            'resolution_details' => 'Outage in progress',
        ]);

        // Optionally, you can send notifications here
        // $this->sendNewOutageNotifications($olt);

        return Redirect::back()->with('success', 'Outage started successfully. Please assign a team.');
    }


    private function sendNewOutageNotifications($olt)
    {
        $verifiedNumbers = [
            '18762922254',
            '18765528469',
            '18764653933',
            '18763477662',
            '18764391884'
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

    private function sendOutageEndNotifications($olt)
    {
        $verifiedNumbers = [
            '18762922254',
            '18765528469',
            '18764653933',
            '18763477662',
            '18764391884'
        ];

        $customers = Customer::where('town_id', $olt->town_id)
                            ->whereIn('telephone', $verifiedNumbers)
                            ->get();

        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilioNumber = env('TWILIO_PHONE_NUMBER');
        $client = new Client($accountSid, $authToken);

        foreach ($customers as $customer) {
            $message = "Dear customer {$customer->customer_name}, the outage at {$olt->olt_name} has been resolved. Thank you for your patience.";
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

            // $this->sendOutageEndNotifications($outage->olt); // Send end notifications
            $this->calculateAndSaveSLA($outage); // Calculate and save SLA
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

    public function teamsWithResource(Request $request)
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
    
        // Find the outage type related to the outage
        $outageType = OutageTypes::find($outage->outage_type_id);

        if (!$outageType) {
            return response()->json(['error' => 'Outage type not found'], 404);
        }

        // Get the required resources
        $requiredResources = [$olt->resource_id, $outageType->resource_id];
        Log::info('Required resources:', ['requiredResources' => $requiredResources]);

        // Retrieve teams with resources matching both the OLT's resource_id and the outage type's resource_id
        $teams = Team::where('status', false)
            ->whereHas('resources', function ($query) use ($requiredResources) {
                $query->whereIn('resources.resource_id', $requiredResources);
            })
            ->with(['resources' => function ($query) use ($requiredResources) {
                $query->whereIn('resources.resource_id', $requiredResources);
            }])
            ->get();

        // Sort teams based on the number of matching resources
        $sortedTeams = $teams->sortByDesc(function ($team) use ($requiredResources) {
            return $team->resources->whereIn('resource_id', $requiredResources)->count();
        })->values();

        return response()->json([
            'olt' => new OLTResource($olt),
            'outageType' => new OutageTypesResource($outageType),
            'teams' => TeamResource::collection($sortedTeams),
            'outage' => new OutageResource($outage),
        ]);
    }

    public function assignTeamToOutage(Request $request)
    {
        $request->validate([
            'outage_id' => 'required|exists:outage_histories,id',
            'team_id' => 'required|exists:teams,team_id',
        ]);

        $outage = OutageHistory::find($request->outage_id);
        $team = Team::find($request->team_id);

        $outage->update([
            'team_id' => $team->team_id,
        ]);

        $team->update(['status' => true]);

        return response()->json(['message' => 'Team assigned successfully']);
    }
    





    public function reassignTeam(Request $request)
    {
        $request->validate([
            'outage_id' => 'required|exists:outage_histories,id',
            'team_id' => 'required|exists:teams,team_id',
        ]);

        //log the outage_id and team_id
        Log::info('Outage ID:', ['outage_id' => $request->outage_id]);
        Log::info('Team ID:', ['team_id' => $request->team_id]);

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