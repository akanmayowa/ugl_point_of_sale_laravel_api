<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexReportBusinessSegmentRequest extends FormRequest
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
            'business_segment_id' => 'nullable|exists:business_segments,id'
        ];
    }
}
