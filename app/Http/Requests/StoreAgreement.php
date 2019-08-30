<?php

namespace App\Http\Requests;

use App\Rules\NoAgreement;
use Illuminate\Foundation\Http\FormRequest;

class StoreAgreement extends FormRequest
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
            'company' => ['required', 'numeric', 'min:1', new NoAgreement],
            'observation' => 'nullable|max:8000',
        ];
    }
}
