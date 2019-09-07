<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Illuminate\Contracts\Validation\Rule;

class StudentAge implements Rule
{
    private $startDate;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($startDate)
    {
        $this->startDate = $startDate;
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

        return $student->getAgeByDate($this->startDate) >= 16;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.age');
    }
}
