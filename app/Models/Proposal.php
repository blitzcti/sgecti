<?php

namespace App\Models;

class Proposal extends Model
{
    protected $fillable = [
        'name', 'company_id', 'course_id', 'deadline', 'schedule_id', 'remuneration', 'description', 'observation',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}