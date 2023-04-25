<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderTransactionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'reference_number' => $this->reference_number,
            'order_id' => $this->order_id,
            'description' => $this->description,
            'amount' => $this->amount,
            'branch_id' => $this->branch_id,
            'transaction_date' => $this->transaction_date,
            'transaction_mode' => new TransactionModeResource($this->transactionMode),
            'staff_id' => $this->staff_id,
            'customer' => new OrderCustomerResource($this->customer),
            'user' => new OrderUserResource($this->user),
        ];
    }
}
