<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
                'reference_number' => $this->reference_number,
                'order_id' => $this->order_id,
                'description' => $this->description,
                'amount' => $this->amount,
                'transaction_date' => $this->transaction_date,
            'branch_id' => $this->branch_id,
            'transaction_mode' => new TransactionModeResource($this->transactionMode),
                'transaction_last_modified_date' => $this->transaction_last_modified_date,
                'staff_id' => $this->staff_id,
                'customer' => new CustomerResource($this->customer),
                'user' => new UserResource($this->user),
        ];
    }
}
