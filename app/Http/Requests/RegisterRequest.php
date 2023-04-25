<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => [ 'required',Rule::in(['male', 'female'] ) ],
            'branch_id' => 'required|exists:branches,id',
            'phone_no' => 'required|string|unique:users,phone_no',
            'staff_id' => 'nullable|unique:users,staff_id',
            'email' => 'required|unique:users,email',
            'password' => 'nullable|string',
            'role' =>  ['required', Rule::in(['cashier', 'admin']) ]
        ];
    }

}
