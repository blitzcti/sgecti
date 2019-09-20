<?php

namespace App\Models;

class Amendment extends Model
{
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

    public function getFormattedProtocolAttribute()
    {
        $protocol = $this->protocol;
        $n = substr($protocol, 0, 3);
        $y = substr($protocol, 3, 4);
        return "$n/$y";
    }
}
