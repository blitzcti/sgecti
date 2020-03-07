<?php

namespace App\Models;

use App\Models\NSac\Student;
use App\Models\Utils\Active;
use App\Models\Utils\Protocol;
use Carbon\Carbon;

/**
 * Model for jobs table.
 *
 * @package App\Models
 * @property int id
 * @property string ra
 * @property string ctps
 * @property int company_id
 * @property int sector_id
 * @property int coordinator_id
 * @property int state_id
 * @property Carbon start_date
 * @property Carbon end_date
 * @property Carbon plan_date
 * @property string protocol
 * @property string approval_number
 * @property string activities
 * @property string observation
 * @property string reason_to_cancel
 * @property Carbon canceled_at
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Student student
 * @property Company company
 * @property Sector sector
 * @property Coordinator coordinator
 * @property State state
 * @property-read boolean dilation
 * @property-read string formatted_protocol
 * @property-read string formatted_ctps
 */
class Job extends Model
{
    use Active;
    use Protocol;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ra', 'ctps', 'company_id', 'coordinator_id', 'state_id', 'start_date', 'end_date', 'protocol', 'observation',
        'reason_to_cancel', 'canceled_at', 'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'coordinator_id' => 'integer',
        'state_id' => 'integer',

        'start_date' => 'date',
        'end_date' => 'date',
        'plan_date' => 'date',
        'canceled_at' => 'datetime',

        'active' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(NSac\Student::class, 'ra');
    }

    public function company()
    {
        return $this->belongsTo(JobCompany::class, 'company_id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function getDilationAttribute()
    {
        $dateS = Carbon::createFromFormat("!Y-m-d", "{$this->student->year}-01-01");
        $max_years = GeneralConfiguration::getMaxYears($dateS);
        $limitDate = $dateS->modify("+{$max_years} year")->modify("-1 day");

        return $this->start_date > $limitDate || $this->end_date > $limitDate;
    }

    public function getFormattedCtpsAttribute()
    {
        $ctps = $this->ctps;
        $p1 = substr($ctps, 0, 6);
        $p2 = substr($ctps, 6, 5);
        return "{$p1}/{$p2}";
    }
}
