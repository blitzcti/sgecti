<?php

namespace App\Models;

use Carbon\Carbon;

class Internship extends Model
{
    protected $fillable = [
        'ra', 'company_id', 'sector_id', 'coordinator_id', 'schedule_id', 'schedule_2_id', 'supervisor_id', 'state_id',
        'start_date', 'end_date', 'protocol', 'activities', 'observation', 'reason_to_cancel', 'canceled_at', 'active',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['estimated_hours'];

    public function student()
    {
        return $this->belongsTo(NSac\Student::class, 'ra');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function schedule2()
    {
        return $this->belongsTo(Schedule::class, 'schedule_2_id', 'id', 'schedule_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function amendments()
    {
        return $this->hasMany(Amendment::class);
    }

    public function not_empty_amendments()
    {
        return $this->hasMany(Amendment::class)->get()->filter(function ($a) {
            $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            foreach ($days as $day) {
                if ($a->schedule->{$day . "_s"} != null || $a->schedule->{$day . "_e"} != null) {
                    return true;
                }
            }

            return false;
        });
    }

    public function bimestral_reports()
    {
        return $this->hasMany(BimestralReport::class);
    }

    public function final_report()
    {
        return $this->hasOne(FinalReport::class);
    }

    public function getEndDateAttribute()
    {
        $endDate = $this->attributes['end_date'];
        foreach ($this->amendments->sortByDesc('id') as $amendment) {
            if ($amendment->new_end_date !== null) {
                $endDate = $amendment->new_end_date;
            }
        }

        return $endDate;
    }

    public function getEstimatedHoursAttribute()
    {
        $amendments = $this->not_empty_amendments();

        $h = $this->schedule->countHours($this->start_date, $this->end_date, $amendments);
        if ($this->schedule2 != null) {
            $h += $this->schedule2->countHours($this->start_date, $this->end_date, $amendments);
        }

        if ($amendments != null) {
            foreach ($amendments as $amendment) {
                $h += $amendment->schedule->countHours($amendment->start_date, $amendment->end_date, $amendments);

                if ($amendment->schedule2 != null) {
                    $h += $amendment->schedule2->countHours($amendment->start_date, $amendment->end_date, $amendments);
                }

                $amendments = $amendments->filter(function ($a) use ($amendment) {
                    return $a->id != $amendment->id;
                });
            }
        }

        return $h;
    }

    public static function requiringFinish()
    {
        $today = Carbon::today()->modify('-20 day');
        return Internship::where('state_id', '=', 1)->where('active', '=', true)->get()->where('end_date', '<=', $today);
    }
}
