<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Exception;
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
        try {
            $student = Student::find($value);
            $cIds = Auth::user()->coordinator_of->map(function ($course) {
                return $course->id;
            })->toArray();

            return in_array($student->course_id, $cIds);
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
        return __('validation.same_course');
    }
}
