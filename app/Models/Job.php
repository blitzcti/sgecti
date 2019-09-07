<?php

namespace App\Models;

class Job extends Model
{
    protected $fillable = [
        'ra', 'ctps', 'company_id', 'coordinator_id', 'state_id', 'start_date', 'end_date', 'protocol', 'observation',
        'active', 'reason_to_cancel',
    ];

    public function student()
    {
        return $this->belongsTo(NSac\Student::class, 'ra');
    }

    public function company()
    {
        return $this->belongsTo(JobCompany::class, 'company_id');
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function getFormattedProtocolAttribute()
    {
        $protocol = $this->protocol;
        $n = substr($protocol, 0, 3);
        $y = substr($protocol, 3, 4);
        return "$n/$y";
    }
}
