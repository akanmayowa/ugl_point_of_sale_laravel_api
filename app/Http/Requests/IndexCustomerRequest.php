<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexCustomerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>  'nullable|string',
            'phone_no' => 'nullable|string',
            'email' => 'nullable|string',
        ];
    }
}
