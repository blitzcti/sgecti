<?php

namespace App\Models;

use App\Models\Utils\Protocol;
use Carbon\Carbon;

/**
 * Model for amendments table.
 *
 * @package App\Models
 * @property int id
 * @property int internship_id
 * @property Carbon start_date
 * @property Carbon end_date
 * @property Carbon new_end_date
 * @property int schedule_id
 * @property int schedule_2_id
 * @property string protocol
 * @property string observation
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Internship internship
 * @property Schedule schedule
 * @property Schedule schedule2
 * @property-read string formatted_protocol
 */
class Amendment extends Model
{
    use Protocol;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'internship_id', 'start_date', 'end_date', 'new_end_date', 'schedule_id', 'schedule_2_id', 'protocol', 'observation',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'internship_id' => 'integer',
        'schedule_id' => 'integer',
        'schedule_2_id' => 'integer',

        'start_date' => 'date',
        'end_date' => 'date',
        'new_end_date' => 'date',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function schedule2()
    {
        return $this->belongsTo(Schedule::class, 'schedule_2_id');
    }
}
