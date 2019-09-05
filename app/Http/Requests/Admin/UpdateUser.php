<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'name' => ['required', 'max:191'],
            'email' => ['required', 'email', 'max:191'],
            'phone' => ['nullable', 'numeric', 'digits_between:10,11'],
            'role' => ['required', 'numeric', 'min:1', 'exists:roles,id'],
        ];
    }
}
