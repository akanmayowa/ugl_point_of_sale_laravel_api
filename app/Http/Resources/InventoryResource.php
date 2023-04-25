<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InventoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' =>  $this->price,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'barcode' => $this->barcode,
            'branch_id' => $this->branch_id,
            'dealer_price' => $this->dealer_price,
            'staff_price' => $this->staff_price,
            'crs_price' => $this->crs_price,
            'unit_of_measurement' => $this->unit_of_measurement,
            'category' => new CategoryResource($this->categories),
            'created_at' => $this->created_at->format('Y-m-d') ?? null,
            'updated_at' => $this->updated_at->format('Y-m-d') ?? null
        ];
    }
}
