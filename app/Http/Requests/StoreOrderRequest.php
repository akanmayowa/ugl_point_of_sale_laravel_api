<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
              'customer_id' => 'required|exists:customers,id',
              'subtotal' => 'required|numeric',
              'total' => 'required|numeric',
              'discount' => 'nullable|numeric',
              'tax' =>  'nullable|numeric',
              'loyalty_discount' => 'nullable|numeric',
              'transaction_mode_id' => 'required|integer|exists:transaction_modes,id',
             'items' => 'required|array',
             'items.*.id' => 'required|integer|exists:inventories,id',
             'items.*.quantity' => 'required|integer',
             'items.*.price' => 'required|numeric',
        ];
    }
}
