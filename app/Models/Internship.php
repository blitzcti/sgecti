<?php

namespace App\Models;

use App\Models\NSac\Student;
use App\Models\Utils\Active;
use App\Models\Utils\Protocol;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Model for internships table.
 *
 * @package App\Models
 * @property int id
 * @property string ra
 * @property int company_id
 * @property int sector_id
 * @property int coordinator_id
 * @property int schedule_id
 * @property int schedule_2_id
 * @property int supervisor_id
 * @property int state_id
 * @property Carbon start_date
 * @property Carbon end_date
 * @property string protocol
 * @property string activities
 * @property string observation
 * @property int reason_to_cancel
 * @property Carbon canceled_at
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Student student
 * @property Company company
 * @property Sector sector
 * @property Coordinator coordinator
 * @property Schedule schedule
 * @property Schedule schedule2
 * @property Supervisor supervisor
 * @property State state
 * @property Collection|Amendment[] amendments
 * @property Collection|Amendment[] not_empty_amendments
 * @property Collection|BimestralReport[] bimestral_reports
 * @property FinalReport final_report
 * @property-read boolean dilation
 * @property-read Carbon a_end_date
 * @property-read int estimated_hours
 * @property-read string formatted_protocol
 * @property-read boolean needsFinalReport
 */
class Internship extends Model
{
    use Active;
    use Protocol;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ra', 'company_id', 'sector_id', 'coordinator_id', 'schedule_id', 'schedule_2_id', 'supervisor_id', 'state_id',
        'start_date', 'end_date', 'protocol', 'activities', 'observation', 'reason_to_cancel', 'canceled_at', 'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'sector_id' => 'integer',
        'coordinator_id' => 'integer',
        'schedule_id' => 'integer',
        'schedule_2_id' => 'integer',
        'supervisor_id' => 'integer',
        'state_id' => 'integer',

        'start_date' => 'date',
        'end_date' => 'date',
        'canceled_at' => 'datetime',

        'active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'estimated_hours',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'amendments',
    ];

    public function student()
    {
        return $this->belongsTo(NSac\Student::class, 'ra');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function schedule2()
    {
        return $this->belongsTo(Schedule::class, 'schedule_2_id', 'id', 'schedule_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function amendments()
    {
        return $this->hasMany(Amendment::class);
    }

    public function getNotEmptyAmendmentsAttribute()
    {
        return $this->amendments->filter(function (Amendment $a) {
            if ($a->schedule == null) {
                return false;
            }

            $days = ['sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat'];
            foreach ($days as $day) {
                if ($a->schedule->{"{$day}_s"} != null || $a->schedule->{"{$day}_e"} != null) {
                    return true;
                }
            }

            return false;
        });
    }

    public function bimestral_reports()
    {
        return $this->hasMany(BimestralReport::class);
    }

    public function final_report()
    {
        return $this->hasOne(FinalReport::class);
    }

    public function getDilationAttribute()
    {
        $dateS = Carbon::createFromFormat("!Y-m-d", "{$this->student->year}-01-01");
        $max_years = GeneralConfiguration::getMaxYears($dateS);
        $limitDate = $dateS->modify("+{$max_years} year")->modify("-1 day");

        return $this->start_date > $limitDate || $this->end_date > $limitDate;
    }

    public function getAEndDateAttribute()
    {
        $endDate = $this->end_date;

        /* @var $amendment Amendment */
        foreach ($this->amendments->sortByDesc('id') as $amendment) {
            if ($amendment->new_end_date !== null) {
                $endDate = $amendment->new_end_date;
            }
        }

        return $endDate;
    }

    public function getEstimatedHoursAttribute()
    {
        $amendments = $this->not_empty_amendments;

        $h = $this->schedule->countHours($this->start_date, $this->end_date, $amendments);
        if ($this->schedule2 != null) {
            $h += $this->schedule2->countHours($this->start_date, $this->end_date, $amendments);
        }

        if ($amendments != null) {
            foreach ($amendments as $amendment) {
                if ($amendment->schedule != null) {
                    $h += $amendment->schedule->countHours($amendment->start_date, $amendment->end_date, $amendments);
                }

                if ($amendment->schedule2 != null) {
                    $h += $amendment->schedule2->countHours($amendment->start_date, $amendment->end_date, $amendments);
                }

                $amendments = $amendments->filter(function (Amendment $a) use ($amendment) {
                    return $a->id != $amendment->id;
                });
            }
        }

        return $h;
    }

    public function needsFinalReport()
    {
        return $this->state_id == State::OPEN && $this->a_end_date <= Carbon::today()->modify('-20 day');
    }

    public static function finishedToday()
    {
        $today = Carbon::today();
        return static::actives()->where('state_id', '=', State::OPEN)->get()->where('a_end_date', '=', $today);
    }

    public static function requiringFinish()
    {
        $today = Carbon::today()->modify('-20 day');
        return static::actives()->where('state_id', '=', State::OPEN)->get()->where('a_end_date', '<=', $today);
    }
}
