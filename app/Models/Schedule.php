<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'mon_s', 'mon_e', 'tue_s', 'tue_e', 'wed_s', 'wed_e', 'thu_s', 'thu_e', 'fri_s', 'fri_e', 'sat_s', 'sat_e',
    ];
}
