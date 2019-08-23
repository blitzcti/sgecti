<?php

namespace App\Models;

class CourseConfiguration extends Model
{
    protected $fillable = [
        'course_id', 'min_year', 'min_semester', 'min_hours', 'min_months', 'min_months_ctps', 'min_grade',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
