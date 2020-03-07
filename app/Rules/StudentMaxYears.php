<?php

namespace App\Rules;

use App\Models\GeneralConfiguration;
use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Throwable;

class StudentMaxYears implements Rule
{
    private $startDate;
    private $endDate;

    /**
     * Create a new rule instance.
     *
     * @param $startDate
     * @param $endDate
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
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

            $dateS = Carbon::createFromFormat("!Y-m-d", "{$student->year}-01-01");
            $max_years = GeneralConfiguration::getMaxYears($dateS);

            $d1 = Carbon::createFromFormat("!Y-m-d", $this->startDate);
            $d2 = Carbon::createFromFormat("!Y-m-d", $this->endDate);
            $limitDate = $dateS->modify("+{$max_years} year")->modify("-1 day");

            return $d1 <= $limitDate && $d2 <= $limitDate;
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
        return __('validation.max_years');
    }
}
