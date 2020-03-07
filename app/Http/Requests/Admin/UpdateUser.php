<?php

namespace App\Http\Requests\Admin;

use App\Models\Role;
use App\Models\User;
use App\Rules\Integer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = User::findOrFail($this->route('id'));

        return $user->isAdmin() || $user->isTeacher();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $usersDB = config('broker.useSSO') ? config('database.sso') : config('database.default');
        $user = User::findOrFail($this->route('id'));

        return [
            'name' => ['required', 'max:191'],
            'email' => ['required', 'email', 'max:191', "unique:{$usersDB}.users,email,{$user->id}"],
            'phone' => ['nullable', new Integer, 'digits_between:10,11'],
            'role' => ['required', 'integer', 'min:1', 'exists:roles,id', Rule::in([Role::ADMIN, Role::TEACHER])],
        ];
    }
}
