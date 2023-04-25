<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>  'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'customer_type_id' => 'required|exists:customer_types,id',
            'address' => 'nullable|string',
            'gender' => [ 'required',Rule::in(['male', 'female'] ) ],
            'business_segment_id' => 'required|exists:business_segments,id'
        ];
    }
}
