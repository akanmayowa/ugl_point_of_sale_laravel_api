<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class ReportTransactionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'reference_number' => $this->reference_number,
                'user_id' => $this->user_id,
                'staff_id' => $this->staff_id,
                'order_id' => $this->order_id,
                'transaction_date' => $this->transaction_date,
                'description' => $this->description,
                'amount' => $this->amount,
                'cashier_total_sales' => $this->cashier_total_sales,
                'created_at' => $this->created_at->format('y-m-d : H:i:s'),
                'pos' => $this->pos,
                'cash' => $this->cash,
                'credit' => $this->credit,
                'bank_transfer' => $this->bank_transfer,
                'others' => $this->others,
                'total' => $this->total,
                'order' => $this->whenLoaded('orders'),
                'employee' => $this->whenLoaded('user'),
                'customer' => $this->whenLoaded('customer'),
                'transaction_mode' => $this->whenLoaded('transactionMode')
        ];
    }

}
