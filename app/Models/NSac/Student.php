<?php

namespace App\Models\NSac;

use App\Models\Course;
use App\Models\Internship;
use App\Models\Job;
use App\Models\State;
use Carbon\Carbon;

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
    protected $appends = ['course_id', 'year', 'grade', 'class', 'age'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'internship', 'finishedInternships',
    ];

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
        if ($this->situacao_matricula > 3) {
            return 4;
        } else {
            return intval(substr($this->turma, 1, 1));
        }
    }

    public function getClassAttribute()
    {
        return substr($this->turma, 2, 1);
    }

    public function getAgeAttribute()
    {
        return $this->getAgeByDate(Carbon::today());
    }

    public function getAgeByDate($date)
    {
        return date_diff(date_create($this->data_de_nascimento), date_create($date))->format("%y");
    }

    public function getCourseConfigurationAttribute()
    {
        return $this->course->configurationAt(Carbon::create($this->year, 1, 1));
    }

    public function getInternshipStateAttribute()
    {
        if ($this->internship != null) {
            return 0;
        } else {
            if (sizeof($this->finishedInternships) > 0) {
                return 1;
            } else {
                return 2;
            }
        }
    }

    public function getCompletedHoursAttribute()
    {
        $internships = $this->finishedInternships;
        $h = 0;
        $h += $internships->reduce(function ($a, $i) {
            $a += $i->final_report->completed_hours;
            return $a;
        });

        return $h;
    }

    public function getCompletedMonthsAttribute()
    {
        $internships = $this->finishedInternships;
        $h = 0;
        $h += $internships->reduce(function ($a, $i) {
            $a += date_diff(date_create($i->start_date), date_create($i->final_report->end_date))->format("%m");
            return $a;
        });

        return $h;
    }

    public function getCtpsCompletedMonthsAttribute()
    {
        $jobs = $this->finishedJobs;
        $h = 0;
        $h += $jobs->reduce(function ($a, $j) {
            $a += date_diff(date_create($j->start_date), date_create($j->end_date))->format("%m");
            return $a;
        });

        return $h;
    }

    public function internship()
    {
        return $this->hasOne(Internship::class, 'ra')->where('state_id', '=', State::OPEN);
    }

    public function finishedInternships()
    {
        return $this->hasMany(Internship::class, 'ra')->where('state_id', '=', State::FINISHED);
    }

    public function job()
    {
        return $this->hasOne(Job::class, 'ra')->where('state_id', '=', State::OPEN);
    }

    public function finishedJobs()
    {
        return $this->hasMany(Job::class, 'ra')->where('state_id', '=', State::FINISHED);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function canGraduate()
    {
        if ($this->situacao_matricula == 5) {
            return true;
        } else if ($this->situacao_matricula == 0) {
            if (($this->completed_hours >= $this->course_configuration->min_hours && $this->completed_months >= $this->course_configuration->min_months)
                || $this->ctps_completed_months >= $this->course_configuration->min_months_ctps) {
                return true;
            }
        }

        return false;
    }

    public static function actives()
    {
        return Student::where('situacao_matricula', '=', 0)->orWhere('situacao_matricula', '=', 5)->get();
    }
}
