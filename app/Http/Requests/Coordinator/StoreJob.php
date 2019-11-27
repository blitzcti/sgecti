<?php

namespace App\Http\Requests\Coordinator;

use App\Models\JobCompany;
use App\Models\NSac\Student;
use App\Rules\Active;
use App\Rules\DateInterval;
use App\Rules\Integer;
use App\Rules\RA;
use App\Rules\StudentHasInternship;
use App\Rules\StudentHasJob;
use App\Rules\StudentMaxYears;
use App\Rules\StudentSameCoordinatorCourse;
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
        $months = Student::find($this->get('ra'))->course_configuration->min_months_ctps ?? 6;

        return [
            'dilation' => ['required', 'boolean'],

            'ra' => ['required', 'integer', 'min:1', new RA, new StudentHasInternship, new StudentHasJob, new StudentSameCoordinatorCourse, (!$this->get('dilation')) ? new StudentMaxYears($this->get('startDate'), $this->get('endDate')) : ''],
            'active' => ['required', 'boolean'],

            'company' => ['required', 'integer', 'min:1', 'exists:job_companies,id', new Active(JobCompany::class)],

            'startDate' => ['required', 'date', 'before:endDate'],
            'endDate' => ['required', 'date', 'after:startDate', new DateInterval($this->get('start_date'), $months)],

            'protocol' => ['required', new Integer, 'digits:7'],
            'activities' => ['nullable', 'max:8000'],
            'observation' => ['nullable', 'max:8000'],

            'ctps' => ['required', new Integer, 'min:11'],
        ];
    }
}
