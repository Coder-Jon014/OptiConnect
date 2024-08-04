<?php

namespace App\Http\Controllers;

use App\Models\OutageHistory;
use App\Http\Resources\OutageResource;
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



    private function calculateAndSaveSLA($outage)
    {
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
            
            // Get team assigned to outage
            $teamAssignedToOutage = $outage->team_id;

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
                $refundAmount = $residentialRefund + $businessRefund;
                $resolutionDetails = 'Outage was not resolved within the SLA';
            } else {
                $refundAmount = 0.00;
                $resolutionDetails = 'Outage was resolved within the SLA';
            }

            //Update Outage Resolution Details
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

        $this->sendNewOutageNotifications($olt);

        // Calculate and save SLA
        $this->calculateAndSaveSLA($outage);

        return Redirect::back()->with('success', 'Outage generated successfully');
    }


    private function sendNewOutageNotifications($olt)
    {
        $verifiedNumbers = [
            '18762922254',
            '18765528469',
            '18763368664',
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

    private function sendOutageEndNotifications($olt)
    {
        $verifiedNumbers = [
            '18762922254',
            '18765528469',
            '18763368664',
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

            $this->sendOutageEndNotifications($outage->olt); // Send end notifications
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

        //Get SLA for outage then get the refund_amount
        $sla = SLA::where('outage_history_id', $outage->id)->first();
        $refund_amount = $sla->refund_amount;
    
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
            'sla' => new SLAResource($sla),
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
