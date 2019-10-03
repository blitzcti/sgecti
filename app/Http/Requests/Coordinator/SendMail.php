<?php

namespace App\Http\Requests\Coordinator;

use App\Rules\ApprovedProposal;
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

            'grades' => [($this->get('useFilters')) ? 'required_without_all:periods,courses,internships' : '', 'nullable', 'array'],
            'grades.*' => ['nullable', 'integer', 'distinct', 'min:1', 'max:4'],
            'periods' => [($this->get('useFilters')) ? 'required_without_all:grades,courses,internships' : '', 'nullable', 'array'],
            'periods.*' => ['nullable', 'integer', 'distinct', 'min:0', 'max:1'],
            'courses' => [($this->get('useFilters')) ? 'required_without_all:grades,periods,internships' : '', 'nullable', 'array'],
            'courses.*' => ['nullable', 'integer', 'distinct', 'min:1', 'exists:courses,id'],
            'internships' => [($this->get('useFilters')) ? 'required_without_all:grades,periods,courses' : '', 'nullable', 'array'],
            'internships.*' => ['nullable', 'integer', 'distinct', 'min:0', 'max:2'],

            'students' => ['required_if:useFilters,0', 'nullable', 'array'],
            'students.*' => ['numeric', 'distinct', 'min:1', new RA],

            'message' => ['nullable', 'integer', 'min:0', 'max:3'],

            'proposal' => ['required_if:message,1', 'nullable', 'integer', 'min:1', 'exists:proposals,id', new ApprovedProposal],

            'subject' => ['required_if:message,3', 'nullable', 'max:100'],
            'messageBody' => ['required_if:message,2', 'required_if:message,3', 'nullable', 'max:8000'],
        ];
    }
}
