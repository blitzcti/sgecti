<?php

namespace App\Models;

class Job extends Model
{
    protected $fillable = [
        'ra', 'ctps', 'company_id', 'sector_id', 'coordinator_id', 'supervisor_id',
        'state_id', 'start_date', 'end_date', 'protocol', 'observation', 'reason_to_cancel', 'active',
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

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
