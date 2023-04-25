<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class customerDebtPaymentRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'debtor_id' => 'required|exists:debtors,id',
                'debtor_number' => 'required|exists:debtors,debtor_number',
                'initial_payment' => 'nullable|numeric',
                'total_amount' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'payment_date' => 'required|string',
        ];
    }
}
