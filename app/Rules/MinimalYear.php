<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Illuminate\Contracts\Validation\Rule;

class MinimalYear implements Rule
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
        $student = Student::find($value);

        return $student->grade >= $student->course_configuration->min_year;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.min_year');
    }
}
