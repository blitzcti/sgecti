<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Illuminate\Contracts\Validation\Rule;

class RA implements Rule
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
        if ((new Student())->isConnected()) {
            $s = Student::find($value)->get();
            return sizeof($s) > 0;
        }

        return strlen($value) == 7;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.ra');
    }
}
