<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'staff_id' => $this->staff_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'gender' => $this->gender,
//            'branch' => new BranchResource($this->branch),
            'user_role' => $this->user_role,
            'user_status' => $this->user_status
        ];
    }
}
