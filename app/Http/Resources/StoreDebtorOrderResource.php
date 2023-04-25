<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreDebtorOrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'total' => $this->total,
            'loyalty_discount' => $this->loyalty_discount,
            'order_date' => $this->order_date,
            'status' =>  $this->status,
        ];
    }
}
