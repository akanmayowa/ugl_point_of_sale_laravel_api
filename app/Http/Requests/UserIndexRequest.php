<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'user_role' => 'required|string',
            'user_status',
            'staff_id',
            'name',
            'email',
            'staff_id',
            'role' ,
        ];
    }
}
