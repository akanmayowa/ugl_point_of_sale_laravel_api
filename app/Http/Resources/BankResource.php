<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
{
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'name' => $this->name,
                'acn_name' => $this->acn_name,
                'acn_no' => $this->acn_no,
        ];
    }
}
