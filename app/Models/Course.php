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

    public function coordinatorAt($date)
    {
        $coordinator = Coordinator::where('course_id', '=', $this->id)
            ->where(function ($query) use ($date) {
                $query->where('end_date', '=', null)
                    ->orWhere('end_date', '>=', $date);
            })
            ->get()->sortBy('id');

        if (sizeof($coordinator) > 0) {
            return $coordinator->last();
        }

        return null;
    }

    public function coordinator()
    {
        return $this->coordinatorAt(Carbon::today()->toDateString());
    }

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class);
    }

    public function configurationAt($dateTime)
    {
        $config = CourseConfiguration::where('course_id', '=', $this->id)
            ->where('created_at', '<=', $dateTime)
            ->get()->sortBy('id');

        if (sizeof($config) > 0) {
            return $config->last();
        }

        return null;
    }

    public function configuration()
    {
        return $this->configurationAt(Carbon::now());
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
}
