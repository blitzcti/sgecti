<?php

namespace App\Models;

class BackupConfiguration extends Model
{
    protected $fillable = [
        'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'hour',
    ];

    public function days()
    {
        $allDays = [
            'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday',
        ];

        $days = [];
        foreach ($allDays as $day) {
            if ($this->{$day}) {
                array_push($days, $day);
            }
        }

        return $days;
    }

    public function cronDays()
    {
        $daysE = $this->days();
        $days = [];
        foreach ($daysE as $dayE) {
            $dayE = strtoupper(substr($dayE, 0, 3));
            array_push($days, $dayE);
        }

        return $days;
    }

    public function getHour()
    {
        return date("H:i", strtotime($this->hour));
    }
}
