<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class TeamResource extends JsonResource
{
    public function toArray($request)
    {
        Log::info('Team Resource Debug', ['team_name' => $this->team_name, 'resource' => $this->resources]);

        return [
            'team_name' => $this->team_name,
            'team_type' => $this->team_type,
            'resource_name' => $this->resources->pluck('resource_name')->toArray(),
        ];
    }
}
