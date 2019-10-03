<?php

namespace App\Rules;

use App\Models\Company;
use App\Models\Course;
use App\Models\NSac\Student;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class CompanyHasCourse implements Rule
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
            $course = Course::find($value);

            return in_array($course->id, $company->courses->map(function ($c) {
                return $c->id;
            })->toArray());
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
        return __('validation.company_has_course');
    }
}
