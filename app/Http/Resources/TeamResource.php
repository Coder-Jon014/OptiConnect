<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class TeamResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'team_id' => $this->team_id,
            'team_name' => $this->team_name,
            'team_type' => $this->team_type,
            'status' => $this->status,
            'resource_name' => $this->resources->pluck('resource_name')->toArray(),
        ];
    }
}
