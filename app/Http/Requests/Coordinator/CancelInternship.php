<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Internship;
use App\Models\State;
use Illuminate\Foundation\Http\FormRequest;

class CancelInternship extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $internship = Internship::findOrFail($this->route('id'));

        return $internship->state_id == State::OPEN;
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
