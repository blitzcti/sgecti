<?php

namespace App\Rules;

use App\Models\NSac\Student;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class StudentHasInternship implements Rule
{
    private $ignore;

    /**
     * Create a new rule instance.
     *
     * @param null $ignore
     */
    public function __construct($ignore = null)
    {
        $this->ignore = $ignore;
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
            $ret = $student->internship == null;
            if (!$ret && $this->ignore != null) {
                $ret = $student->internship->id == $this->ignore;
            }

            return $ret;
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
        return __('validation.already_has_internship');
    }
}
