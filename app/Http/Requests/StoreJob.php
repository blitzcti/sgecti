<?php

namespace App\Http\Requests;

use App\Rules\CompanyHasCourse;
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
            'ra' => ['required', 'numeric', 'min:1', new RA, new HasInternship, new SameCourse, new CompanyHasCourse($this->get('company'))],
            'active' => 'required|numeric|min:1',
            'company' => ['required', 'min:1', new HasCourse],
            'sector' => 'required|min:1',
            'startDate' => 'required|date|before:endDate',
            'endDate' => 'required|date|after:startDate',

            'supervisor' => 'required|numeric|min:1',

            'protocol' => 'required|max:5',
            'observation' => 'max:200',

            'ctps' => 'required|numeric|min:11',
        ];
    }
}
