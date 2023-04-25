<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDebtorRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'nullable|exists:debtors,id',
            'customer_id' => 'required|exists:customers,id',
            'initial_payment' => 'required|numeric',
//            'total_amount' => 'required|numeric',
			'discount' => 'nullable|numeric',
            'order_number' => 'required|exists:orders,order_number',
            'payment_date' => 'required'
        ];
    }
}
