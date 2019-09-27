<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;

/**
 * Class Schedule
 *
 * @package App\Models
 * @property int id
 * @property string mon_s
 * @property string mon_e
 * @property string tue_s
 * @property string tue_e
 * @property string wed_s
 * @property string wed_e
 * @property string thu_s
 * @property string thu_e
 * @property string fri_s
 * @property string fri_e
 * @property string sat_s
 * @property string sat_e
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Internship internship
 * @property Amendment amendment
 * @property Proposal proposal
 */
class Schedule extends Model
{
    protected $fillable = [
        'mon_s', 'mon_e', 'tue_s', 'tue_e', 'wed_s', 'wed_e', 'thu_s', 'thu_e', 'fri_s', 'fri_e', 'sat_s', 'sat_e',
    ];

    public function internship()
    {
        return $this->hasOne(Internship::class);
    }

    public function amendment()
    {
        return $this->hasOne(Amendment::class);
    }

    public function proposal()
    {
        return $this->hasOne(Proposal::class);
    }

    public function countHours($startDate, $endDate, $amendments)
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

            $amendments = $amendments->filter(function ($a) use ($i) {
                $amendment = $this->amendment;
                if ($amendment != null) {
                    return $a->id != $this->amendment->id && $a->start_date == $i->format('Y-m-d');
                } else {
                    return $a->start_date == $i->format('Y-m-d');
                }
            })->sortBy('end_date');

            if (sizeof($amendments) > 0) {
                $amendment = $amendments->first();
                $y = date("Y", strtotime($amendment->end_date));
                $m = date("m", strtotime($amendment->end_date));
                $d = date("d", strtotime($amendment->end_date));
                $i->setDate($y, $m, $d);
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
