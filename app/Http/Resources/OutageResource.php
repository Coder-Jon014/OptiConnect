<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            "olt" => $this->olt_id,
            "team_id" => $this->team_id,
            "team" => $this->team ? $this->team->team_name : null,
            "start_time" => $this->start_time,
            "end_time" => $this->end_time,
            "duration" => $this->duration / 3600,
        ];
    }
}
