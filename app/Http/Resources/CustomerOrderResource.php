<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerOrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'total' => $this->total,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'loyalty_discount' => $this->loyalty_discount,
            'order_date' => $this->order_date,
            'created_at' => $this->created_at,
        ];
    }
}
