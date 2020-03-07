<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use App\Rules\Integer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUser extends FormRequest
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
        $usersDB = config('broker.useSSO') ? config('database.sso') : config('database.default');

        return [
            'name' => ['required', 'max:191'],
            'email' => ['required', 'email', 'max:191', 'unique:{$usersDB}.users,email'],
            'phone' => ['nullable', new Integer, 'digits_between:10,11'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required', 'integer', 'min:1', 'exists:roles,id', Rule::in([Role::ADMIN, Role::TEACHER])],
        ];
    }
}
