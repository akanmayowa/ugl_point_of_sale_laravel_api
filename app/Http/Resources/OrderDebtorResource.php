<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDebtorResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'debtor_number' => $this->debtor_number,
            'order_id' => $this->order_id,
            'order_number' => $this->order_number,
            'customer_id' => $this->customer_id,
            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'status' => $this->status,
            'branch_id' => $this->branch_id,
            'payment_duration' => $this->payment_duration,
            'payment_date' => $this->payment_date,
         ];
    }
}
