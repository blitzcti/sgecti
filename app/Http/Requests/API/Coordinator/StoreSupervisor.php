<?php

namespace App\Http\Requests\API\Coordinator;

use App\Http\Requests\API\FormRequest;
use App\Rules\Integer;

class StoreSupervisor extends FormRequest
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
            'company' => ['required', 'integer', 'min:1', 'exists:companies,id'],
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50'],
            'phone' => ['required', new Integer, 'digits_between:10,11'],
        ];
    }
}
