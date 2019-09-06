<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Company;
use App\Rules\Active;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupervisor extends FormRequest
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
            'company' => ['required', 'numeric', 'min:1', 'exists:companies,id', new Active(Company::class)],
            'supervisorName' => ['required', 'max:50'],
            'supervisorEmail' => ['required', 'max:50'],
            'supervisorPhone' => ['required', 'numeric', 'digits_between:10,11'],
        ];
    }
}
