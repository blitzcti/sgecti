<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class BackupConfiguration
 *
 * @package App\Models
 * @property int id
 * @property boolean sunday
 * @property boolean monday
 * @property boolean tuesday
 * @property boolean wednesday
 * @property boolean thursday
 * @property boolean friday
 * @property boolean saturday
 * @property string hour
 * @property Carbon created_at
 * @property Carbon updated_at
 */
class BackupConfiguration extends Model
{
    protected $fillable = [
        'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'hour',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'sunday' => 'boolean',
        'monday' => 'boolean',
        'tuesday' => 'boolean',
        'wednesday' => 'boolean',
        'thursday' => 'boolean',
        'friday' => 'boolean',
        'saturday' => 'boolean',
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
