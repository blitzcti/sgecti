<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Route implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value == null) {
            return true;
        }

        return \Illuminate\Support\Facades\Route::has($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.route');
    }
}
