<?php

namespace App\Rules;

use App\Auth;
use App\Models\Company;
use App\Models\Course;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class CompanyHasCoordinatorCourse implements Rule
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
            $courses = Auth::user()->coordinator_of;
            $company = Company::find($value);

            return sizeof($company->courses->map(function (Course $course) use ($courses) {
                    return $courses->contains($course);
                })) > 0;
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
        return __('validation.company_has_coordinator_course');
    }
}
