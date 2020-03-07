<?php

namespace App\Rules;

use App\Models\Company;
use App\Models\NSac\Student;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class CompanyHasStudentCourse implements Rule
{
    private $company_id;

    /**
     * Create a new rule instance.
     *
     * @param $company_id
     */
    public function __construct($company_id)
    {
        $this->company_id = $company_id;
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
            $company = Company::find($this->company_id);
            $student = Student::find($value);

            return $company->courses->contains($student->course);
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
        return __('validation.company_has_course');
    }
}
