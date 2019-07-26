<?php

namespace App\Models;

class Internship extends Model
{
    protected $fillable = [
        'ra', 'ctps', 'company_id', 'sector_id', 'coordinator_id', 'schedule_id', 'schedule_2_id', 'supervisor_id',
        'state_id', 'start_date', 'end_date', 'protocol', 'activities', 'observation', 'reason_to_cancel', 'active',
    ];

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
        return $this->belongsTo(Schedule::class, 'schedule_2_id');
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

    public function estimatedHours()
    {
        $h = $this->schedule->countHours($this->start_date, $this->end_date);
        if ($this->schedule2 != null) {
            $h += $this->schedule2->countHours($this->start_date, $this->end_date);
        }

        if ($this->amendments != null) {
            foreach ($this->amendments as $amendment) {
                $h += $amendment->schedule->countHours($amendment->start_date, $amendment->end_date);
            }
        }

        return $h;
    }
}
