<?php

namespace App\Http\Requests\Coordinator;

use Illuminate\Foundation\Http\FormRequest;

class StudentPDF extends FormRequest
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
            'grades' => ['required_without_all:periods,classes,courses,internships', 'nullable', 'array'],
            'grades.*' => ['nullable', 'numeric', 'distinct', 'min:1', 'max:4'],
            'periods' => ['required_without_all:grades,classes,courses,internships', 'nullable', 'array'],
            'periods.*' => ['nullable', 'numeric', 'distinct', 'min:0', 'max:1'],
            'classes' => ['required_without_all:grades,periods,courses,internships', 'nullable', 'array'],
            'classes.*' => ['nullable', 'alpha', 'distinct', 'regex:/^[A-Z]$/u'],
            'courses' => ['required_without_all:grades,periods,classes,internships', 'nullable', 'array'],
            'courses.*' => ['nullable', 'numeric', 'distinct', 'min:1', 'exists:courses,id'],
            'internships' => ['required_without_all:grades,periods,classes,courses', 'nullable', 'array'],
            'internships.*' => ['nullable', 'numeric', 'distinct', 'min:0', 'max:2'],
        ];
    }
}
