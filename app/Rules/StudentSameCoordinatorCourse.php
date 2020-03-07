<?php

namespace App\Rules;

use App\Auth;
use App\Models\NSac\Student;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class StudentSameCoordinatorCourse implements Rule
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
            $student = Student::find($value);

            return Auth::user()->coordinator_of->contains($student->course);
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
        return __('validation.same_course');
    }
}
