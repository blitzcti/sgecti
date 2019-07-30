<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAmendment extends FormRequest
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
            'has2Turnos' => 'required|boolean',

            'internship' => 'required|numeric|min:1',
            'startDate' => 'required|date|before:endDate',
            'endDate' => 'required|date|after:startDate',

            'monS' => 'nullable|date_format:H:i',
            'monE' => 'nullable|date_format:H:i',
            'tueS' => 'nullable|date_format:H:i',
            'tueE' => 'nullable|date_format:H:i',
            'wedS' => 'nullable|date_format:H:i',
            'wedE' => 'nullable|date_format:H:i',
            'thuS' => 'nullable|date_format:H:i',
            'thuE' => 'nullable|date_format:H:i',
            'friS' => 'nullable|date_format:H:i',
            'friE' => 'nullable|date_format:H:i',
            'satS' => 'nullable|date_format:H:i',
            'satE' => 'nullable|date_format:H:i',

            'monS2' => 'nullable|date_format:H:i',
            'monE2' => 'nullable|date_format:H:i',
            'tueS2' => 'nullable|date_format:H:i',
            'tueE2' => 'nullable|date_format:H:i',
            'wedS2' => 'nullable|date_format:H:i',
            'wedE2' => 'nullable|date_format:H:i',
            'thuS2' => 'nullable|date_format:H:i',
            'thuE2' => 'nullable|date_format:H:i',
            'friS2' => 'nullable|date_format:H:i',
            'friE2' => 'nullable|date_format:H:i',
            'satS2' => 'nullable|date_format:H:i',
            'satE2' => 'nullable|date_format:H:i',

            'protocol' => 'required|max:5',
            'observation' => 'max:200',
        ];
    }
}
