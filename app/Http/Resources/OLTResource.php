<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OLTResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "olt_id" => $this->id,
            "olt_name" => $this->olt_name,
            "parish_id" => $this->parish ? $this->parish->parish_name : null,
            "town" => $this->town ? $this->town->town_name : null,
            "customer_count" => $this->customer_count,
            "business_customer_count" => $this->business_customer_count,
            "residential_customer_count" => $this->residential_customer_count,
            "olt_value" => $this->olt_value,
            "rank" => $this->rank,
            "level" => $this->level,
            "resource_id" => $this->resource,
            "resource" => $this->resource ? $this->resource->resource_name : null,
        ];
    }
}
