<?php

namespace App\Rules;

use App\Models\GeneralConfiguration;
use App\Models\NSac\Student;
use Exception;
use Illuminate\Contracts\Validation\Rule;

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

            $dateS = date_create("{$student->year}-01-01");
            $max_years = GeneralConfiguration::getMaxYears($dateS);
            $d1 = date_create($this->startDate);
            $d2 = date_create($this->endDate);
            $limitDate = $dateS->modify("+{$max_years} year")->modify("-1 day");

            return $d1 <= $limitDate && $d2 <= $limitDate;
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
        return __('validation.max_years');
    }
}
