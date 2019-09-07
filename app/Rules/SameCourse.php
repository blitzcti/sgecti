<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SameCourse implements Rule
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
        $cIds = Auth::user()->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();

        return in_array($student->course_id, $cIds);
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
