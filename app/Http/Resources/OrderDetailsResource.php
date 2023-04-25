<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailsResource extends JsonResource
{

    public function toArray($request)
    {
        return [
                 'id' => $this->id,
                'order_id' => $this->id,
                'inventory_id' => $this->inventory_id,
                'quantity' => $this->quantity,
                'price' => $this->price,
                'amount' => $this->amount,
                'discount' => $this->discount,
                'loyalty_discount' => $this->loyalty_discount,
                'branch_id' => $this->branch_id,
                'inventory' => new InventoryResource($this->inventory)
            ];
    }
}
