<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBankRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'id' => 'nullable|exists:banks,id',
                'name' => 'required|string',
                'acn_name' => 'required|string',
        ];
    }
}
