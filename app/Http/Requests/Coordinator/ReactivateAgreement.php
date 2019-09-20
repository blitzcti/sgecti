<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Agreement;
use Illuminate\Foundation\Http\FormRequest;

class ReactivateAgreement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $agreement = Agreement::findOrFail($this->route('id'));

        return !$agreement->active && !$agreement->company->hasAgreementAt($agreement->start_date);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
