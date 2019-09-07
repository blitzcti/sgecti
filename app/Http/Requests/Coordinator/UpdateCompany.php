<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Company;
use App\Models\Course;
use App\Models\Sector;
use App\Rules\Active;
use App\Rules\Integer;
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
        $company = Company::findOrFail($this->route('id'));

        return [
            'ie' => ['nullable', new Integer, 'digits:10'],
            'active' => ['required', 'boolean'],
            'name' => ['required', 'max:191'],
            'fantasyName' => ['nullable', 'max:191'],
            'email' => ['nullable', 'email', 'max:191'],
            'phone' => ['nullable', new Integer, 'digits_between:10,11'],

            'representativeName' => ['required', 'max:50'],
            'representativeRole' => ['required', 'max:50'],

            'cep' => ['required', new Integer, 'digits:8'],
            'uf' => ['required', 'max:2'],
            'city' => ['required', 'max:30'],
            'street' => ['required', 'max:50'],
            'complement' => ['nullable', 'max:50'],
            'number' => ['required', 'max:6'],
            'district' => ['required', 'max:50'],

            'sectors' => ['required', 'array', 'min:1'],
            'sectors.*' => ['required', 'integer', 'distinct', 'min:1', 'exists:sectors,id', new Active(Sector::class, $company->sectors)],
            'courses' => ['required', 'array', 'min:1'],
            'courses.*' => ['required', 'integer', 'distinct', 'min:1', 'exists:courses,id', new Active(Course::class, $company->courses)],
        ];
    }
}
