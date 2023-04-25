<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebtorEmployeeResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'full_name' => $this->first. '' .$this->last_name,
            'staff_id' => $this->staff_id
        ];
    }
}
