<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Job;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class CancelJob extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $job = Job::findOrFail($this->route('id'));

        return $job->state_id == State::OPEN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'canceledAt' => ['required', 'date'],
            'reasonToCancel' => ['required', 'max:8000'],
        ];
    }
}
