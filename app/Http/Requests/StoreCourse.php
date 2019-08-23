<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourse extends FormRequest
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
            'hasConfig' => 'required|boolean',

            'name' => 'required|max:30',
            'color' => 'required|numeric|min:1',
            'active' => 'required|boolean',

            'minYear' => 'required_if:hasConfig,1|numeric|min:1|max:3',
            'minSemester' => 'required_if:hasConfig,1|numeric|min:1|max:2',
            'minHour' => 'required_if:hasConfig,1|numeric|min:1',
            'minMonth' => 'required_if:hasConfig,1|numeric|min:1',
            'minMonthCTPS' => 'required_if:hasConfig,1|numeric|min:1',
            'minGrade' => 'required_if:hasConfig,1|numeric|min:0|max:10',
        ];
    }
}
