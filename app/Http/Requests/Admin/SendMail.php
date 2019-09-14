<?php

namespace App\Http\Requests\Admin;

use App\Rules\RA;
use Illuminate\Foundation\Http\FormRequest;

class SendMail extends FormRequest
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
            'useFilters' => ['required', 'boolean'],

            'grades' => [($this->get('useFilters')) ? 'required_without_all:periods,classes,courses,internships' : '', 'nullable', 'array'],
            'grades.*' => ['nullable', 'integer', 'distinct', 'min:1', 'max:4'],
            'periods' => [($this->get('useFilters')) ? 'required_without_all:grades,classes,courses,internships' : '', 'nullable', 'array'],
            'periods.*' => ['nullable', 'integer', 'distinct', 'min:0', 'max:1'],
            'classes' => [($this->get('useFilters')) ? 'required_without_all:grades,periods,courses,internships' : '', 'nullable', 'array'],
            'classes.*' => ['nullable', 'alpha', 'distinct', 'regex:/^[A-Z]$/u'],
            'courses' => [($this->get('useFilters')) ? 'required_without_all:grades,periods,classes,internships' : '', 'nullable', 'array'],
            'courses.*' => ['nullable', 'integer', 'distinct', 'min:1', 'exists:courses,id'],
            'internships' => [($this->get('useFilters')) ? 'required_without_all:grades,periods,classes,courses' : '', 'nullable', 'array'],
            'internships.*' => ['nullable', 'integer', 'distinct', 'min:0', 'max:2'],

            'students' => ['required_if:useFilters,0', 'nullable', 'array'],
            'students.*' => ['numeric', 'distinct', 'min:1', new RA],

            'subject' => ['required', 'nullable', 'max:100'],
            'messageBody' => ['required', 'max:8000'],
        ];
    }
}
