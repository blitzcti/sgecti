<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSystemConfiguration extends FormRequest
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
            'name' => 'required|max:60',
            'cep' => 'required|numeric',
            'uf' => 'required|max:2',
            'city' => 'required|max:30',
            'street' => 'required|max:50',
            'number' => 'required|max:6',
            'district' => 'required|max:50',
            'phone' => 'required|max:11',
            'email' => 'required|max:50',
            'extension' => 'max:5',
            'agreementExpiration' => 'required|numeric|min:1',
        ];
    }
}
