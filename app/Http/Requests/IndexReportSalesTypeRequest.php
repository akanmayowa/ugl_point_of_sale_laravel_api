<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexReportSalesTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'nullable|string',
            'transaction_mode_id' => 'nullable|integer|exists:transaction_modes,id',
            'end_date' => 'nullable|string',
        ];
    }
}
