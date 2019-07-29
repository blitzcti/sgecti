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
}
