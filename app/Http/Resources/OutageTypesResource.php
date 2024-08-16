<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Resource;

class OutageTypesResource extends JsonResource
{
    public function toArray($request)
    {
        $resource = Resource::find($this->resource_id);
        $resourceName = $resource ? $resource->resource_name : null;

        $response = [
            // 'outage_type_id' => $this->outage_type_id,
            'outage_type_name' => $this->outage_type_name,
            // 'resource_id' => $this->resource_id,
            'resource_name' => $resourceName
        ];

        return $response;
    }
}
