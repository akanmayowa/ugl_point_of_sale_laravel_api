<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' =>  'nullable|string',
            'email' => 'nullable|unique:customers|email',
            'phone_number' => 'nullable|string',
            'customer_type_id' => 'nullable|exists:customer_types,id',
            'address' => 'nullable|string',
            'gender' => [ 'nullable',Rule::in(['male', 'female'] ) ],
            'business_segment_id' => 'nullable|exists:business_segments,id'
        ];
    }
}
