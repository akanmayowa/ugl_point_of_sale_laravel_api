<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentDurationResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'duration' => $this->duration,
            'created_at' => $this->created_at->format('y-m-d') ?? null,
            'updated_at' => $this->updated_at->format('y-m-d') ?? null,
        ];
    }
}
