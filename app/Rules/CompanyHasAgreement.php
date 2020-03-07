<?php

namespace App\Rules;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class CompanyHasAgreement implements Rule
{
    private $date;

    /**
     * Create a new rule instance.
     *
     * @param $date
     */
    public function __construct($date)
    {
        if ($date == null) {
            $this->date = Carbon::today();
        } else {
            $this->date = Carbon::createFromFormat("!Y-m-d", $date);
        }
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

            return $company->hasAgreementAt($this->date);
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
        return __('validation.no_agreement');
    }
}
