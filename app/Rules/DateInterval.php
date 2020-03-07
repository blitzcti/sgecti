<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateInterval implements Rule
{
    private $startDate;
    private $months;

    /**
     * Create a new rule instance.
     *
     * @param $startDate
     * @param $months
     */
    public function __construct($startDate, $months)
    {
        $this->startDate = $startDate;
        $this->months = $months;
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
        $diff = Carbon::createFromFormat("!Y-m-d", $this->startDate)->diff(Carbon::createFromFormat("!Y-m-d", $value));
        $mDiff = $diff->y * 12 + $diff->m;

        return $mDiff >= $this->months;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return str_replace(':months', $this->months, __('validation.min_interval'));
    }
}
