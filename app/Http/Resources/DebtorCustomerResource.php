<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebtorCustomerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'customer_type' => new CustomerTypeResource($this->customerType),
            'address' => $this->address,
            'gender' => $this->gender,
            'business_segment' => new BusinessSegmentResource($this->businessSegment)
        ];
    }
}
