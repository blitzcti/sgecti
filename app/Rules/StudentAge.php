<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class StudentAge implements Rule
{
    private $startDate;

    /**
     * Create a new rule instance.
     *
     * @param $startDate
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
        try {
            $student = Student::find($value);

            return $student->getAgeByDate($this->startDate) >= 16;
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
        return __('validation.age');
    }
}
