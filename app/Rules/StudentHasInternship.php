<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class StudentHasInternship implements Rule
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
            $student = Student::findOrFail($value);

            return $student->internship == null;
        } catch (Exception $e) {
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
        return __('validation.already_has_internship');
    }
}
