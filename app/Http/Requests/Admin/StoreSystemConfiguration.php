<?php

namespace App\Http\Requests\Admin;

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
            'name' => ['required', 'max:60'],
            'cep' => ['required', 'numeric', 'digits:8'],
            'uf' => ['required', 'max:2'],
            'city' => ['required', 'max:30'],
            'street' => ['required', 'max:50'],
            'number' => ['required', 'max:6'],
            'district' => ['required', 'max:50'],
            'phone' => ['required', 'numeric', 'digits_between:10,11'],
            'email' => ['required', 'email', 'max:50'],
            'extension' => ['nullable', 'numeric', 'digits_between:3,4'],
            'agreementExpiration' => ['required', 'numeric', 'min:1'],
        ];
    }
}
