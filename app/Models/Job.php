<?php

namespace App\Models;

use App\Models\NSac\Student;
use Carbon\Carbon;

/**
 * Class Job
 *
 * @package App\Models
 * @property int id
 * @property int ra
 * @property string ctps
 * @property int company_id
 * @property int coordinator_id
 * @property int state_id
 * @property int start_date
 * @property int end_date
 * @property int protocol
 * @property int observation
 * @property int reason_to_cancel
 * @property int canceled_at
 * @property int active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Student student
 * @property Company company
 * @property Coordinator coordinator
 * @property State state
 * @property string formatted_protocol
 * @property string formatted_ctps
 */
class Job extends Model
{
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

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function getFormattedProtocolAttribute()
    {
        $protocol = $this->protocol;
        $n = substr($protocol, 0, 3);
        $y = substr($protocol, 3, 4);
        return "$n/$y";
    }

    public function getFormattedCtpsAttribute()
    {
        $ctps = $this->ctps;
        $p1 = substr($ctps, 0, 6);
        $p2 = substr($ctps, 6, 5);
        return "$p1/$p2";
    }
}
