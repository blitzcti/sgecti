<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CPF implements Rule
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
        if (empty($value)) {
            return false;
        }

        $value = preg_replace("/[^0-9]/", "", $value);
        $value = str_pad($value, 11, '0', STR_PAD_LEFT);

        if (strlen($value) != 11) {
            return false;
        } else if ($value == '00000000000' ||
            $value == '11111111111' ||
            $value == '22222222222' ||
            $value == '33333333333' ||
            $value == '44444444444' ||
            $value == '55555555555' ||
            $value == '66666666666' ||
            $value == '77777777777' ||
            $value == '88888888888' ||
            $value == '99999999999') {
            return false;
        } else {

            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $value{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($value{$c} != $d) {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.cpf');
    }
}
