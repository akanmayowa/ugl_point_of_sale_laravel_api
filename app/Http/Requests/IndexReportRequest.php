<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexReportRequest extends FormRequest
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
            'user_id' => 'nullable|integer'
        ];
    }
}
