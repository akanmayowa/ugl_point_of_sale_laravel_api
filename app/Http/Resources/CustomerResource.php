<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'transaction_sum_amount' => $this->transaction_sum_amount,
            'customer_type' => new CustomerTypeResource($this->customerType),
            'address' => $this->address,
            'gender' => $this->gender,
            'order' =>  CustomerOrderResource::collection($this->order),
            'business_segment' => new BusinessSegmentResource($this->businessSegment)
        ];
    }
}
