<?php

namespace App\Http\Requests\Coordinator;

use App\Rules\CompanyHasNoAgreement;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAgreement extends FormRequest
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
            'startDate' => ['required', 'date'],
            'observation' => ['nullable', 'max:8000'],
        ];
    }
}
