<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexReportInventoryOrProductTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'start_date' => 'nullable|string',
            'end_date' => 'nullable|string',
            'inventory_id' => 'nullable|exists:inventories,id'
        ];
    }
}
