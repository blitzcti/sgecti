<?php

namespace App\Models;

class Amendment extends Model
{
    protected $fillable = [
        'internship_id', 'start_date', 'end_date', 'schedule_id', 'protocol', 'observation',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
