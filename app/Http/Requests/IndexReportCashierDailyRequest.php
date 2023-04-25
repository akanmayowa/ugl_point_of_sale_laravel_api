<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexReportCashierDailyRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'start_date' => 'nullable',
            'end_date' => 'nullable',
        ];
    }
}
