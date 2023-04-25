<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderUserResource extends JsonResource
{

    public function toArray($request)
    {

        return [
//            'id' => $this->id,
//            'staff_id' => $this->staff_id,
//            'full_name' => $this->first_name .', '. $this->last_name,
//            'email' => $this->email,
//            'branch_id' => $this->branch_id,
                $this->load('branch')
        ];

    }
}
