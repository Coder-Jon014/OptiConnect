<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SLAResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_type' => $this->customerType->customer_type_name,
            'outage_id' => $this->outage_history_id,
            'max_duration' => $this->max_duration,
            'compensation_details' => $this->compensation_details,
            'refund_amount' => $this->refund_amount ?? 0, // Ensure refund_amount is included
        ];
    }
}
