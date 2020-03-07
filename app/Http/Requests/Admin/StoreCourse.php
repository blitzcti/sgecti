<?php

namespace App\Http\Requests\Admin;

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
            'hasConfig' => ['required', 'boolean'],

            'name' => ['required', 'max:30'],
            'color' => ['required', 'integer', 'min:1', 'exists:colors,id'],
            'active' => ['required', 'boolean'],

            'minYear' => ['required_if:hasConfig,1', 'nullable', 'integer', 'min:1', 'max:3'],
            'minSemester' => ['required_if:hasConfig,1', 'nullable', 'integer', 'min:1', 'max:2'],
            'minHours' => ['required_if:hasConfig,1', 'nullable', 'integer', 'min:1', 'max:9999'],
            'minMonths' => ['required_if:hasConfig,1', 'nullable', 'integer', 'min:1', 'max:24'],
            'minMonthsCTPS' => ['required_if:hasConfig,1', 'nullable', 'integer', 'min:1', 'max:999'],
            'minGrade' => ['required_if:hasConfig,1', 'nullable', 'numeric', 'min:0', 'max:10'],
        ];
    }
}
