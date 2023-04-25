<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBranchRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
               'id' => 'nullable|exists:branches,id',
                'name' => 'required|string',
                'address' => 'required|string',
                'email' => 'required|email',
                'phone_no' => 'required|string',
        ];
    }
}
