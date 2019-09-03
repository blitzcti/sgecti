<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreProposal extends FormRequest
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
            'hasSchedule' => ['required', 'boolean'],
            'has2Schedules' => ['required', 'boolean'],

            'type' => ['required', 'numeric', 'min:0', 'max:1'],
            'remuneration' => ['required', 'numeric', 'min:0'],
            'description' => ['required', 'max:8000'],
            'requirements' => ['required', 'max:8000'],
            'benefits' => ['nullable', 'max:8000'],
            'contact' => ['required', 'max:8000'],
            'deadline' => ['required', 'date'],
            'observation' => ['nullable', 'max:8000'],
        ];
    }
}
