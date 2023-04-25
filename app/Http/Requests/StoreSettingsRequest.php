<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreSettingsRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'tax_rate' => 'required',
            'tax_name' => 'required|string',
            'low_stock_alert' => 'required|integer',
            'discount_password' => 'required|string',
        ];
    }
}
