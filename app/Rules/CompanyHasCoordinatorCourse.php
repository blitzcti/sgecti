<?php

namespace App\Rules;

use App\Models\Company;
use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
            $company = Company::find($value);

            return array_map(function ($c) {
                return in_array($c["id"], Auth::user()->coordinator_of->toArray());
            }, $company->courses->toArray());
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
        return __('validation.has_course');
    }
}
