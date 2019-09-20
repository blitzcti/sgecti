<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Company;
use App\Rules\Active;
use App\Rules\CompanyHasEmail;
use App\Rules\CompanyHasNoAgreement;
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
            'company' => ['required', 'integer', 'min:1', 'exists:companies,id', new CompanyHasNoAgreement, new CompanyHasEmail, new Active(Company::class)],
            'startDate' => ['required', 'date'],
            'observation' => ['nullable', 'max:8000'],
        ];
    }
}
