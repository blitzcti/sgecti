<?php

namespace App\Models;

class Schedule extends Model
{
    protected $fillable = [
        'mon_s', 'mon_e', 'tue_s', 'tue_e', 'wed_s', 'wed_e', 'thu_s', 'thu_e', 'fri_s', 'fri_e', 'sat_s', 'sat_e',
    ];
}
