<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|exists:users,id',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'gender' => [ 'nullable',Rule::in(['male', 'female'] ) ],
            'phone_no' => 'nullable',
            'branch_id' => 'nullable|exists:branches,id',
        ];
    }
}
