<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexDebtorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'search' => 'nullable|string'
        ];
    }
}
