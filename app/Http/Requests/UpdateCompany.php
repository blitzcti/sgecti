<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Rules\CNPJ;
use App\Rules\CPF;
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
        $company = Company::find($this->route('id'));

        return [
            'pj' => ['required', 'boolean'],

            'cpfCnpj' => ['required', 'numeric', "unique:companies,cpf_cnpj,$company->id", ($this->get('pj')) ? new CNPJ : new CPF],
            'ie' => ['nullable', 'numeric', 'digits:10'],
            'active' => ['required', 'boolean'],
            'name' => ['required', 'max:191'],
            'fantasyName' => ['nullable', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'phone' => ['nullable', 'numeric', 'digits_between:10,11'],

            'representativeName' => ['required', 'max:50'],
            'representativeRole' => ['required', 'max:50'],

            'cep' => ['required', 'numeric', 'digits:8'],
            'uf' => ['required', 'max:2'],
            'city' => ['required', 'max:30'],
            'street' => ['required', 'max:50'],
            'complement' => ['nullable', 'max:50'],
            'number' => ['required', 'max:6'],
            'district' => ['required', 'max:50'],

            'sectors' => ['required', 'array', 'min:1'],
            'sectors.*' => ['required', 'numeric', 'distinct', 'min:1', 'exists:sectors,id'],
            'courses' => ['required', 'array', 'min:1'],
            'courses.*' => ['required', 'numeric', 'distinct', 'min:1', 'exists:courses,id'],
        ];
    }
}
