<?php

namespace App\Http\Requests\Coordinator;

use App\Rules\CNPJ;
use App\Rules\CPF;
use App\Rules\Integer;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobCompany extends FormRequest
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
            'pj' => ['required', 'boolean'],

            'cpfCnpj' => ['required', new Integer, 'unique:job_companies,cpf_cnpj', ($this->get('pj')) ? new CNPJ : new CPF],
            'ie' => ['nullable', new Integer, 'digits:10'],
            'companyName' => ['required', 'max:191'],
            'fantasyName' => ['nullable', 'max:191'],

            'representativeName' => ['required', 'max:50'],
            'representativeRole' => ['required', 'max:50'],

            'active' => ['required', 'boolean'],
        ];
    }
}
