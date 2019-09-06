<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class HourInterval implements Rule
{
    private $startDate;
    private $startDate2;
    private $endDate2;

    /**
     * Create a new rule instance.
     *
     * @param $startDate
     */
    public function __construct($startDate, $startDate2, $endDate2)
    {
        $this->startDate = $startDate;
        $this->startDate2 = $startDate2;
        $this->endDate2 = $endDate2;
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
        $diff = date_diff(date_create($this->startDate), date_create($value));
        $diff2 = date_diff(date_create($this->startDate2), date_create($this->endDate2));
        $hDiff = $diff->format("%h") + $diff2->format("%h");
        $mDiff = $diff->format("%m") + $diff2->format("%m");

        if ($hDiff == 6) {
            if ($mDiff > 0) {
                return false;
            }

            return false;
        } else {
            return $hDiff > 0 && $hDiff <= 6;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.minHours');
    }
}
