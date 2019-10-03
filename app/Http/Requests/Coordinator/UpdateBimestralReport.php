<?php

namespace App\Http\Requests\Coordinator;

use App\Rules\Integer;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBimestralReport extends FormRequest
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
            'date' => ['required', 'date'],
            'protocol' => ['required', new Integer, 'digits:7'],
        ];
    }
}
