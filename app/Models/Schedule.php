<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;

class Schedule extends Model
{
    protected $fillable = [
        'mon_s', 'mon_e', 'tue_s', 'tue_e', 'wed_s', 'wed_e', 'thu_s', 'thu_e', 'fri_s', 'fri_e', 'sat_s', 'sat_e',
    ];

    public function countHours($startDate, $endDate)
    {
        $startDate = new DateTime($startDate);
        $endDate = (Carbon::now() <= new DateTime($endDate)) ? Carbon::now() : new DateTime($endDate);
        $h = 0.0;

        $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];

        for ($i = $startDate; $i < $endDate; $i->modify('+1 day')) {
            $weekDay = $i->format('w');
            if ($weekDay == 0) {
                continue;
            }

            $hs = substr($this->{$days[$weekDay] . '_s'}, 0, 2);
            $ms = substr($this->{$days[$weekDay] . '_s'}, 3, 2);
            $he = substr($this->{$days[$weekDay] . '_e'}, 0, 2);
            $me = substr($this->{$days[$weekDay] . '_e'}, 3, 2);

            $mDiff = (intval($me) - intval($ms));
            $hDiff = (intval($he) - intval($hs));
            if ($mDiff < 0) {
                $hDiff--;
                $mDiff += 60;
            }

            $mDiff = 100 * $mDiff / 60.0;

            $h += floatval("$hDiff.$mDiff");
        }

        return $h;
    }
}
