<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class MinimalSemester implements Rule
{
    private $date;

    /**
     * Create a new rule instance.
     *
     * @param null $date
     */
    public function __construct($date = null)
    {
        if ($date == null) {
            $date = date("Y-m-d");
        }

        $this->date = Carbon::createFromFormat("!Y-m-d", $date);
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
            $semester = ($this->date->month < 7) ? 1 : 2;

            return $semester >= $student->course_configuration->min_semester;
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
        return __('validation.min_semester');
    }
}
