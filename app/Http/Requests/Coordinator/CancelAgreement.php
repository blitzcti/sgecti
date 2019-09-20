<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Agreement;
use Illuminate\Foundation\Http\FormRequest;

class CancelAgreement extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $agreement = Agreement::findOrFail($this->route('id'));

        return $agreement->active;
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
