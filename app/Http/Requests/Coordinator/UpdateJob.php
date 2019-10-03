<?php

namespace App\Http\Requests\Coordinator;

use App\Rules\Integer;
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
        return [
            'active' => ['required', 'boolean'],

            'startDate' => ['required', 'date', 'before:endDate'],
            'endDate' => ['required', 'date', 'after:startDate'],

            'protocol' => ['required', new Integer, 'digits:7'],
            'activities' => ['nullable', 'max:8000'],
            'observation' => ['nullable', 'max:8000'],

            'ctps' => ['required', new Integer, 'min:11'],
        ];
    }
}
