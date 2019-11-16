<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Job;
use App\Rules\DateInterval;
use App\Rules\Integer;
use App\Rules\RA;
use App\Rules\StudentHasInternship;
use App\Rules\StudentHasJob;
use App\Rules\StudentMaxYears;
use App\Rules\StudentSameCoordinatorCourse;
use Illuminate\Foundation\Http\FormRequest;

class UpdateJob extends FormRequest
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
        $job = Job::findOrFail($this->route('id'));
        $months = $job->student->course_configuration->min_months_ctps;

        return [
            'dilation' => ['required', 'boolean'],

            'ra' => ['required', 'integer', 'min:1', new RA, new StudentHasInternship, new StudentHasJob($job->id), new StudentSameCoordinatorCourse, (!$this->get('dilation')) ? new StudentMaxYears($this->get('startDate'), $this->get('endDate')) : ''],
            'active' => ['required', 'boolean'],

            'startDate' => ['required', 'date', 'before:endDate'],
            'endDate' => ['required', 'date', 'after:startDate', new DateInterval($this->get('start_date'), $months)],

            'protocol' => ['required', new Integer, 'digits:7'],
            'activities' => ['nullable', 'max:8000'],
            'observation' => ['nullable', 'max:8000'],

            'ctps' => ['required', new Integer, 'min:11'],
        ];
    }
}
