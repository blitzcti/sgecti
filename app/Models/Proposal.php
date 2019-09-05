<?php

namespace App\Models;

class Proposal extends Model
{
    protected $fillable = [
        'name', 'company_id', 'deadline', 'schedule_id', 'remuneration', 'description', 'requirements', 'benefits',
        'contact', 'type', 'observation',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function schedule2()
    {
        return $this->belongsTo(Schedule::class, 'schedule_2_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'proposal_courses');
    }

    public function syncCourses($courses)
    {
        $this->courses()->sync($courses);
    }
}
