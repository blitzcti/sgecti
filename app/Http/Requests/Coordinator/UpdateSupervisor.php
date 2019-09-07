<?php

namespace App\Http\Requests\Coordinator;

use App\Models\Company;
use App\Models\Supervisor;
use App\Rules\Active;
use App\Rules\Integer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSupervisor extends FormRequest
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
        $supervisor = Supervisor::findOrFail($this->route('id'));

        return [
            'company' => ['required', 'integer', 'min:1', 'exists:companies,id', new Active(Company::class, $supervisor->id)],
            'supervisorName' => ['required', 'max:50'],
            'supervisorEmail' => ['required', 'email', 'max:50'],
            'supervisorPhone' => ['required', new Integer, 'digits_between:10,11'],
        ];
    }
}
