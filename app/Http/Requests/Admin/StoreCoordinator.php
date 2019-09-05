<?php

namespace App\Http\Requests\Admin;

use App\Rules\TemporaryCoordinator;
use Illuminate\Foundation\Http\FormRequest;

class StoreCoordinator extends FormRequest
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
            'user' => ['required', 'numeric', 'min:1', 'exists:users,id'],
            'course' => ['required', 'numeric', 'min:1', 'exists:courses,id'],
            'tempOf' => ['required', 'numeric', 'min:0', new TemporaryCoordinator($this->get('user'), $this->get('course')), ($this->get('tempOf') > 0) ? 'exists:coordinators,id' : ''],
            'startDate' => ['required', 'date'],
            'endDate' => ['nullable', 'date', 'after:startDate'],
        ];
    }
}
