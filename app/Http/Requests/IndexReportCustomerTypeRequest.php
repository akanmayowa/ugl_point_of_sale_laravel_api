<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexReportCustomerTypeRequest extends FormRequest
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
            'customer_type_id' => 'nullable|exists:customer_types,id'
        ];
    }
}
