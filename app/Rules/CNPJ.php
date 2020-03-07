<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CNPJ implements Rule
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
        $value = str_pad($value, 14, '0', STR_PAD_LEFT);

        if (strlen($value) != 14) {
            return false;
        } elseif ($value == '00000000000000' ||
            $value == '11111111111111' ||
            $value == '22222222222222' ||
            $value == '33333333333333' ||
            $value == '44444444444444' ||
            $value == '55555555555555' ||
            $value == '66666666666666' ||
            $value == '77777777777777' ||
            $value == '88888888888888' ||
            $value == '99999999999999') {
            return false;

        } else {
            $j = 5;
            $k = 6;
            $soma1 = 0;
            $soma2 = 0;

            for ($i = 0; $i < 13; $i++) {
                $j = ($j == 1) ? 9 : $j;
                $k = ($k == 1) ? 9 : $k;

                $soma2 += ($value[$i] * $k);

                if ($i < 12) {
                    $soma1 += ($value[$i] * $j);
                }

                $k--;
                $j--;
            }

            $digito1 = ($soma1 % 11 < 2) ? 0 : 11 - $soma1 % 11;
            $digito2 = ($soma2 % 11 < 2) ? 0 : 11 - $soma2 % 11;

            return $value[12] == $digito1 && $value[13] == $digito2;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.cnpj');
    }
}
