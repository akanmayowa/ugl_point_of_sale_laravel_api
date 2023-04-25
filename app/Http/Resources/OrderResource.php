<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        return [
                    'id' => $this->id,
                    'order_number' => $this->order_number,
                    'subtotal' => $this->subtotal,
                    'total' => $this->total,
                    'discount' => $this->discount,
                    'tax' =>  $this->tax,
                    'loyalty_discount' => $this->loyalty_discount,
                    'staff_id' => $this->staff_id,
                    'order_date' => $this->order_date,
                    'status' =>  $this->status,
            'branch_id' => $this->branch_id,
            'created_at' => $this->created_at,
                    'payment_type' => $this->payment_type,
                    'employee' => new OrderUserResource($this->employee),
                    'customer' => new OrderCustomerResource($this->customer),
                    'order_detail' => OrderDetailsResource::collection($this->orderDetail),
                    'transaction' => new OrderTransactionResource($this->transaction),
                    'debtor' => new OrderDebtorResource($this->debtor),
        ];
    }
}
