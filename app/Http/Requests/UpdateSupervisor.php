<?php

namespace App\Http\Requests;

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
        return [
            'supervisorName' => 'required|max:50',
            'supervisorEmail' => 'required|max:50',
            'supervisorPhone' => 'required|max:12',
            'company' => 'required|min:1',
        ];
    }
}
