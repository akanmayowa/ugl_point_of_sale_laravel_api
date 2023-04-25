<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class DebtorResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'debtor_number' => $this->debtor_number,
            'order_id' => $this->order_id,
            'customer_id' => $this->customer_id,
            'total_amount' => $this->total_amount,
			'discount' => $this->discount,
            'payment_duration' => $this->payment_duration,
			'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'order' => new DebtorOrderResource($this->order),
            'customer' => new DebtorCustomerResource($this->customer),
            'debt_detail' => DebtorDetailResource::collection($this->debtorDetails),
            'employee' => new DebtorEmployeeResource($this->employee),
        ];
    }
}
