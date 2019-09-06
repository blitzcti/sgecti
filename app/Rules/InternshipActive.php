<?php

namespace App\Rules;

use App\Models\Internship;
use Illuminate\Contracts\Validation\Rule;

class InternshipActive implements Rule
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
        $internship = Internship::find($value);

        return $internship->state->id == 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.internship_not_active');
    }
}
