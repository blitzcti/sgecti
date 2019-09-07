<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseConfiguration extends FormRequest
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
            'minYear' => ['required', 'integer', 'min:1', 'max:3'],
            'minSemester' => ['required', 'integer', 'min:1', 'max:2'],
            'minHour' => ['required', 'integer', 'min:1', 'max:9999'],
            'minMonth' => ['required', 'integer', 'min:1', 'max:24'],
            'minMonthCTPS' => ['required', 'integer', 'min:1', 'max:999'],
            'minGrade' => ['required', 'numeric', 'min:0', 'max:10'],
        ];
    }
}
