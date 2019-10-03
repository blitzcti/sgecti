<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class BimestralReport
 *
 * @package App\Models
 * @property int id
 * @property int internship_id
 * @property Carbon date
 * @property string protocol
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Internship internship
 * @property string formatted_protocol
 */
class BimestralReport extends Model
{
    protected $fillable = [
        'internship_id', 'date', 'protocol',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'internship_id' => 'integer',

        'date' => 'date',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function getFormattedProtocolAttribute()
    {
        $protocol = $this->protocol;
        $n = substr($protocol, 0, 3);
        $y = substr($protocol, 3, 4);
        return "$n/$y";
    }
}
