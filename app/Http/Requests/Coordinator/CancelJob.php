<?php

namespace App\Http\Requests\Coordinator;

use App\Http\Requests\API\FormRequest;

class CancelJob extends FormRequest
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
            'canceledAt' => ['required', 'date'],
            'reasonToCancel' => ['required', 'max:8000'],
        ];
    }
}
