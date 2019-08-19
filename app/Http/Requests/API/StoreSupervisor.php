<?php

namespace App\Http\Requests\API;

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
            'supervisorName' => 'required|max:50',
            'supervisorEmail' => 'required|max:50',
            'supervisorPhone' => 'required|numeric|digits_between:10,11',
            'company' => 'required|min:1',
        ];
    }
}
