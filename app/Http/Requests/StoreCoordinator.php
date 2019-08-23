<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoordinator extends FormRequest
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
            'user' => 'required|numeric|min:1',
            'course' => 'required|numeric|min:1',
            'tempOf' => 'required|numeric|min:0',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after:startDate',
        ];
    }
}
