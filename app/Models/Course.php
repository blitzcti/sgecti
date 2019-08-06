<?php

namespace App\Models;

use App\Models\NSac\Student;
use Carbon\Carbon;

class Course extends Model
{
    protected $fillable = [
        'name', 'color_id', 'active',
    ];

    public function getStudentsAttribute()
    {
        return Student::all()->where('course_id', '=', $this->id);
    }

    public function coordinators()
{
    return $this->hasMany(Coordinator::class);
}

    public function configurations()
    {
        return $this->hasMany(CourseConfiguration::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_courses');
    }

    public function proposals()
    {
        return $this->belongsToMany(Proposal::class, 'proposal_courses');
    }

    public function coordinatorAt($date)
    {
        $coordinator = $this->coordinators->where('end_date', $date != null ? '>' : '=', $date)->sortBy('id');
        return $coordinator->last();
    }

    public function coordinator()
    {
        $coordinator = $this->coordinatorAt(Carbon::today()->toDateString()) ?? $this->coordinatorAt(null);
        return $coordinator;
    }

    public function configurationAt($dateTime)
    {
        $config = $this->configurations->where('created_at', '<=', $dateTime)->sortBy('id');
        return $config->last();
    }

    public function configuration()
    {
        return $this->configurationAt(Carbon::now());
    }
}
