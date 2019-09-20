<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Job;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class ReactivateJob extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $job = Job::findOrFail($this->route('id'));
        $student = $job->student;

        return $job->state_id == State::CANCELED && $student->job == null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
