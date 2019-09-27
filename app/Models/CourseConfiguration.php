<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class CourseConfiguration
 *
 * @package App\Models
 * @property int id
 * @property int course_id
 * @property int min_year
 * @property int min_semester
 * @property int min_hours
 * @property int min_months
 * @property int min_months_ctps
 * @property float min_grade
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Course course
 */
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
