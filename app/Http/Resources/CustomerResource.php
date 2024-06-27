<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'telephone' => $this->telephone,
            // 'town' => $this->town,
            // 'customerType' => $this->customerType,
        ];
    }
}
