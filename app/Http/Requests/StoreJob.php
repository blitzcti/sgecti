<?php

namespace App\Http\Requests;

use App\Rules\CNPJ;
use App\Rules\CompanyHasCourse;
use App\Rules\CPF;
use App\Rules\HasCourse;
use App\Rules\HasInternship;
use App\Rules\RA;
use App\Rules\SameCourse;
use Illuminate\Foundation\Http\FormRequest;

class StoreJob extends FormRequest
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
            'companyPJ' => 'required|boolean',

            'ra' => ['required', 'numeric', 'min:1', new RA, new HasInternship, new SameCourse],
            'active' => 'required|numeric|min:1',

            'companyCpfCnpj' => ['required', 'numeric', ($this->get('companyPJ')) ? new CNPJ : new CPF],
            'companyIE' => 'nullable|numeric|digits_between:10,10',
            'companyName' => 'required|max:191',
            'companyFantasyName' => 'max:191',

            'startDate' => 'required|date|before:endDate',
            'endDate' => 'required|date|after:startDate',

            'protocol' => 'required|max:5',
            'observation' => 'nullable|max:200',
            'activities' => 'nullable|max:6000',

            'ctps' => 'required|numeric|min:11',
        ];
    }
}
