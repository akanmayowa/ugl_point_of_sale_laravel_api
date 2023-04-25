<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone_no' => $this->phone_no,
            'email' => $this->email,
            'address' => $this->address,
        ];
    }
}
