<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class MinimalSemester implements Rule
{
    private $date;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date)
    {
        if ($date == null) {
            $date = date("Y-m-d");
        }

        $this->date = Carbon::createFromFormat("Y-m-d", $date);
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
        $semester = ($this->date->month < 7) ? 1 : 2;
        return $semester >= $student->course_configuration->min_semester;
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
