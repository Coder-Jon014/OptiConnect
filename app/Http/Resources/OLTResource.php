<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use App\Models\Resource;

class OLTResource extends JsonResource
{
    public function toArray($request)
    {
        // Store the resource_id in a variable
        $resourceId = $this->resource_id;

        // Query the Resource model to get the resource name
        $resource = Resource::find($resourceId);
        $resourceName = $resource ? $resource->resource_name : null;

        // Log detailed resource information
        // Log::info('OLT Resource Debug', [
        //     'olt_name' => $this->olt_name,
        //     'resource_id' => $resourceId,
        //     'resource_name' => $resourceName,
        // ]);

        $response = [
            'olt_name' => $this->olt_name,
            'parish' => $this->parish ? $this->parish->parish_name : null,
            'town' => $this->town ? $this->town->town_name : null,
            'customer_count' => $this->customer_count,
            'business_customer_count' => $this->business_customer_count,
            'residential_customer_count' => $this->residential_customer_count,
            'olt_value' => $this->olt_value,
            'level' => $this->level,
            'resource_name' => $resourceName,
        ];

        // Log the response
        // Log::info('OLT Resource Response', ['response' => $response]);

        return $response;
    }
}
