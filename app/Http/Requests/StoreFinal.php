<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFinal extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'internship' => 'required|numeric|min:1',
            'date' => 'required|date',

            'grade_1_a' => 'required|numeric|min:0|max:5',
            'grade_1_b' => 'required|numeric|min:0|max:5',
            'grade_1_c' => 'required|numeric|min:0|max:5',
            'grade_2_a' => 'required|numeric|min:0|max:5',
            'grade_2_b' => 'required|numeric|min:0|max:5',
            'grade_2_c' => 'required|numeric|min:0|max:5',
            'grade_2_d' => 'required|numeric|min:0|max:5',
            'grade_3_a' => 'required|numeric|min:0|max:5',
            'grade_3_b' => 'required|numeric|min:0|max:5',
            'grade_4_a' => 'required|numeric|min:0|max:5',
            'grade_4_b' => 'required|numeric|min:0|max:5',
            'grade_4_c' => 'required|numeric|min:0|max:5',

            'hoursCompleted' => 'required|numeric|min:1|max:9999',
            'endDate' => 'required|date',

            'observation' => 'nullable|max:8000',
        ];
    }
}
