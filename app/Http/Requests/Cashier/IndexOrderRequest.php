<?php

namespace App\Http\Requests\Cashier;

use Illuminate\Foundation\Http\FormRequest;

class IndexOrderRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'order_number' => 'nullable|string',
            'id' => 'nullable|exists:orders,id'
        ];
    }
}
