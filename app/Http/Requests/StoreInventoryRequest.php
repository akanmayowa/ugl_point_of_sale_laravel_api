<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:inventories,name',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'barcode' => 'nullable|string',
            'dealer_price' => 'nullable|numeric',
            'staff_price' => 'nullable|numeric',
            'crs_price' => 'nullable|numeric',
            'unit_of_measurement' => 'required|string'
        ];
    }
}
