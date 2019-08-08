<?php

namespace App\Models\NSac;

use App\Models\Course;
use App\Models\Internship;

class Student extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "alunos_view";

    /**
     * primaryKey
     *
     * @var string
     * @access protected
     */
    protected $primaryKey = "matricula";

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['course_id', 'year', 'grade', 'class'];

    public function getCourseIdAttribute()
    {
        $id = substr($this->matricula, 3, 1);
        return intval($id);
    }

    public function getYearAttribute()
    {
        $y = substr($this->matricula, 0, 2);
        $y = (intval($y) < 82) ? "20$y" : "19$y";
        return intval($y);
    }

    public function getGradeAttribute()
    {
        $g = substr($this->turma, 1, 1);
        return $g;
    }

    public function getClassAttribute()
    {
        $c = substr($this->turma, 2, 1);
        return $c;
    }

    public function internship()
    {
        return $this->hasOne(Internship::class, 'ra')->where('state_id', '=', 1);
    }

    public function finishedInternships()
    {
        return $this->hasMany(Internship::class, 'ra')->where('state_id', '=', 2);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
