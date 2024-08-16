<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OutageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "outage_id" => $this->id,
            "olt" => $this->olt ? $this->olt->olt_name : null,
            "team_id" => $this->team_id,
            "team" => $this->team ? $this->team->team_name : null,
            "deployment_cost" => $this->team ? $this->team->deployment_cost : null,
            "team_type" => $this->team ? $this->team->team_type : null,
            "start_time" => (new Carbon($this->start_time))->format('Y-m-d H:i:s') ,
            "end_time" => (new Carbon($this->end_time))->format('Y-m-d H:i:s'),
            "duration" => $this->duration / 3600,
            "status" => $this->status,
            "refund_amount" => $this->sla ? $this->sla->refund_amount : 0.00,
            "outage_type" => $this->outageType ? $this->outageType->outage_type_name : null,
        ];
    }
}