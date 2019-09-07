<?php

namespace App\Rules;

use App\Models\Coordinator;
use App\Models\Course;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class TemporaryCoordinator implements Rule
{
    private $user;
    private $course;

    /**
     * Create a new rule instance.
     *
     * @param $user
     * @param $course
     */
    public function __construct($user, $course)
    {
        $this->user = $user;
        $this->course = $course;
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
        if ($value == 0) {
            return true;
        }

        $user = User::find($this->user);
        $course = Course::find($this->course);
        $coordinator = Coordinator::find($value);

        return $coordinator->course_id == $course->id && $coordinator->user_id != $user->id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.temp_of');
    }
}
