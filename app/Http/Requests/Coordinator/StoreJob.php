<?php

namespace App\Http\Requests\Coordinator;

use App\Rules\HasInternship;
use App\Rules\RA;
use App\Rules\SameCourse;
use Illuminate\Foundation\Http\FormRequest;

class StoreJob extends FormRequest
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
            'ra' => ['required', 'numeric', 'min:1', new RA, new HasInternship, new SameCourse],
            'active' => ['required', 'boolean'],

            'company' => ['required', 'numeric', 'min:1', 'exists:job_companies,id'],

            'startDate' => ['required', 'date', 'before:endDate'],
            'endDate' => ['required', 'date', 'after:startDate'],

            'protocol' => ['required', 'numeric', 'digits:5'],
            'activities' => ['nullable', 'max:8000'],
            'observation' => ['nullable', 'max:8000'],

            'ctps' => ['required', 'numeric', 'min:11'],
        ];
    }
}
