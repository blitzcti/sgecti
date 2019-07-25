<?php

namespace App\Models;

class Amendment extends Model
{
    protected $fillable = [
        'internship_id', 'start_date', 'end_date', 'schedule_id', 'protocol', 'observation',
    ];

    public function internship()
    {
        return $this->hasOne(Internship::class);
    }
}
