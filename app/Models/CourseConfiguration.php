<?php

namespace App\Models;

class CourseConfiguration extends Model
{
    protected $fillable = [
        'course_id', 'min_year', 'min_semester', 'min_hours', 'min_months', 'min_months_ctps', 'min_grade',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'course_id' => 'integer',
        'min_year' => 'integer',
        'min_semester' => 'integer',
        'min_hours' => 'integer',
        'min_months' => 'integer',
        'min_months_ctps' => 'integer',
        'min_grade' => 'float',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
