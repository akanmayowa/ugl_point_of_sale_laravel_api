<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'tax_rate' => $this->tax_rate,
            'tax_name' => $this->tax_name,
            'low_stock_alert' => $this->low_stock_alert,
            'discount_password' => $this->discount_password,
            'branch_id' => $this->branch_id,
        ];
    }
}
