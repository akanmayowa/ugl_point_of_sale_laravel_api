<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'types' => 'required|string',
            'price_type' => 'nullable|integer',
            'id' => 'nullable|exists:customer_types,id'
        ];
    }
}
