<?php

namespace App\Rules;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class HasAgreement implements Rule
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
            $this->date = Carbon::today();
        } else {
            $this->date = Carbon::createFromFormat("Y-m-d", $date);
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $company = Company::find($value);
        return $company->hasAgreementAt($this->date);
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
