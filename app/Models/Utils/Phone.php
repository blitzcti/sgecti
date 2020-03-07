<?php

namespace App\Models\Utils;

trait Phone
{
    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        if ($phone == null) {
            return null;
        }

        $ddd = substr($phone, 0, 2);
        $p1 = (strlen($phone) == 10) ? substr($phone, 2, 4) : substr($phone, 2, 5);
        $p2 = (strlen($phone) == 10) ? substr($phone, 6, 4) : substr($phone, 7, 4);
        return "({$ddd}) {$p1}-{$p2}";
    }
}
