<?php

namespace App\Models\NSac;

use App\APIUtils;
use App\Models\Course;
use App\Models\CourseConfiguration;
use App\Models\GeneralConfiguration;
use App\Models\Internship;
use App\Models\Job;
use App\Models\State;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Model for students table.
 *
 * @package App\Models\NSac
 * @property string matricula
 * @property string nome
 * @property string email
 * @property string email2
 * @property string turma
 * @property int turma_ano
 * @property int turma_periodo
 * @property int situacao_matricula
 * @property Carbon data_de_nascimento
 * @property string rg
 * @property string cpf
 * @property string telefone
 * @property string logradouro
 * @property string numero
 * @property string complemento
 * @property string cep
 * @property string bairro
 * @property string cidade
 * @property string codigo_ibge
 * @property string estado
 * @property string uf
 *
 * @property-read int course_id
 * @property-read int year
 * @property-read int grade
 * @property-read int class
 * @property-read int age
 * @property-read CourseConfiguration|GeneralConfiguration course_configuration
 * @property-read int internship_state
 * @property-read int job_state
 * @property-read int completed_hours
 * @property-read int completed_months
 * @property-read int ctps_completed_months
 *
 * @property Internship internship
 * @property Collection|Internship[] finished_internships
 * @property Job job
 * @property Course course
 */
class Student extends Model
{
    public const MORNING = 0;
    public const NIGHT = 1;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'turma_ano' => 'integer',
        'turma_periodo' => 'integer',
        'situacao_matricula' => 'integer',

        'data_de_nascimento' => 'date',
    ];

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
        'internship', 'finished_internships', 'job',
    ];

    public function getUfAttribute()
    {
        $url = APIUtils::parseURL('apis.uf.url', $this->codigo_ibge);
        $json = APIUtils::getData($url);

        return $json['microrregiao']['mesorregiao']['UF']['sigla'];
    }

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
        return $this->data_de_nascimento->diff($date)->y;
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
            if (sizeof($this->finished_internships) > 0) {
                return 1;
            } else {
                return 2;
            }
        }
    }

    public function getJobStateAttribute()
    {
        if ($this->job != null) {
            return 0;
        } else {
            return 1;
        }
    }

    public function getCompletedHoursAttribute()
    {
        $internships = $this->finished_internships;
        $h = 0;
        $h += $internships->reduce(function ($a, $i) {
            /* @var $i Internship */
            $a += $i->final_report->completed_hours;
            return $a;
        });

        return $h;
    }

    public function getCompletedMonthsAttribute()
    {
        $internships = $this->finished_internships;
        $h = 0;
        $h += $internships->reduce(function ($a, $i) {
            /* @var $i Internship */
            $interval = $i->final_report->end_date->diff($i->start_date);
            $a += $interval->m + $interval->y * 12;
            return $a;
        });

        return $h;
    }

    public function getCtpsCompletedMonthsAttribute()
    {
        $h = 0;
        if ($this->job != null) {
            $interval = $this->job->start_date->diff($this->job->end_date);
            $h += $interval->m + $interval->y * 12;
        }

        return $h;
    }

    public function internship()
    {
        return $this->hasOne(Internship::class, 'ra')->where('state_id', '=', State::OPEN);
    }

    public function finished_internships()
    {
        return $this->hasMany(Internship::class, 'ra')->where('state_id', '=', State::FINISHED);
    }

    public function job()
    {
        return $this->hasOne(Job::class, 'ra')->where('state_id', '=', State::FINISHED);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function canGraduate()
    {
        if ($this->situacao_matricula == 0) {
            if (($this->completed_hours >= $this->course_configuration->min_hours && $this->completed_months >= $this->course_configuration->min_months)
                || $this->ctps_completed_months >= $this->course_configuration->min_months_ctps) {
                return true;
            }
        }

        return false;
    }

    public static function actives()
    {
        return static::where('situacao_matricula', '=', 0)->orWhere('situacao_matricula', '=', 5)->get();
    }
}
