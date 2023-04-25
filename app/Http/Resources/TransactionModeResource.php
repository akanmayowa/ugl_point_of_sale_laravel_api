<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionModeResource extends JsonResource
{

    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'transaction_mode' => $this->transaction_mode
        ];
    }
}
