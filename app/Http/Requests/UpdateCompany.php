<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompany extends FormRequest
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
            'pj' => 'required|boolean',

            'ie' => 'nullable|numeric|digits_between:10,10',
            'active' => 'required|boolean',
            'name' => 'required|max:191',
            'fantasyName' => 'max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|numeric|digits_between:10,11',

            'representativeName' => 'required|max:50',
            'representativeRole' => 'required|max:50',

            'cep' => 'required|max:9',
            'uf' => 'required|max:2',
            'city' => 'required|max:30',
            'street' => 'required|max:50',
            'complement' => 'max:50',
            'number' => 'required|max:6',
            'district' => 'required|max:50',

            'sectors' => 'required|array|min:1',

            'courses' => 'required|array|min:1',
        ];
    }
}
