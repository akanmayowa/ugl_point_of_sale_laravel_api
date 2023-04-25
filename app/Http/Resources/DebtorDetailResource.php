<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DebtorDetailResource extends JsonResource
{

    public function toArray($request)
    {
        return [
             'id' => $this->id,
            'debtor_id' => $this->debtor_id,
            'debtor_number' => $this->debtor_number,
            'initial_payment' => $this->initial_payment,
            'total_amount' => $this->total_amount,
            'discount' => $this->discount,
            'user_id' => $this->user_id,
            'payment_date' => $this->payment_date
        ];
    }
}
