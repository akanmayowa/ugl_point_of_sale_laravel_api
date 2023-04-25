<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionModeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
                'id' => 'nullable|exists:transaction_modes,id',
                'transaction_mode' => 'required|string'
        ];
    }
}
