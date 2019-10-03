<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Internship;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class ReactivateInternship extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $internship = Internship::findOrFail($this->route('id'));
        $student = $internship->student;

        return $internship->state_id == State::CANCELED && $student->internship == null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $internship = Internship::findOrFail($this->route('id'));

        return [
            //
        ];
    }
}
