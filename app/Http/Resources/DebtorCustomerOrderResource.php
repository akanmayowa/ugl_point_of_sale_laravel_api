<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebtorCustomerOrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number,
            'branch_id' => $this->branch_id,
            'customer' => $this->whenLoaded('customer'),
        ];
    }
}
