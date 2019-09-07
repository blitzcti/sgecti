<?php

namespace App\Http\Requests\Coordinator;

use App\Models\JobCompany;
use App\Rules\Active;
use App\Rules\HasInternship;
use App\Rules\Integer;
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
            'ra' => ['required', 'integer', 'min:1', new RA, new HasInternship, new SameCourse],
            'active' => ['required', 'boolean'],

            'company' => ['required', 'integer', 'min:1', 'exists:job_companies,id', new Active(JobCompany::class)],

            'startDate' => ['required', 'date', 'before:endDate'],
            'endDate' => ['required', 'date', 'after:startDate'],

            'protocol' => ['required', new Integer, 'digits:7'],
            'activities' => ['nullable', 'max:8000'],
            'observation' => ['nullable', 'max:8000'],

            'ctps' => ['required', new Integer, 'min:11'],
        ];
    }
}
