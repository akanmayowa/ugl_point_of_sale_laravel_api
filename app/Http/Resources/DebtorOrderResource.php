<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebtorOrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'discount' => $this->discount,
            'tax' =>  $this->tax,
            'loyalty_discount' => $this->loyalty_discount,
            'staff_id' => $this->staff_id,
            'order_date' => $this->order_date,
            'order_last_updated_date' => $this->order_last_updated_date,
            'status' =>  $this->status,
            'payment_type' => $this->payment_type,
            'created_at' => $this->created_at,
            'employee' => new UserResource($this->employee),
            'customer' => new CustomerResource($this->customer),
        ];
    }
}
