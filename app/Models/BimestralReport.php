<?php

namespace App\Models;

class BimestralReport extends Model
{
    protected $fillable = [
        'internship_id', 'date', 'protocol',
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
