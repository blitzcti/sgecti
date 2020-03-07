<?php

namespace App\Rules;

use App\Models\Internship;
use App\Models\State;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class InternshipIsOpen implements Rule
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
        try {
            $internship = Internship::find($value);

            return $internship->state->id == State::OPEN;
        } catch (Throwable $e) {
            return false;
        }
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
