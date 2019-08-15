<?php

namespace App\Models;

class GeneralConfiguration extends Model
{
    protected $fillable = [
        'max_years', 'start_date', 'end_date',
    ];

    public static function getMaxYears($date) {
        $configs = GeneralConfiguration::whereDate('start_date', '<=', $date)->sortBy('id');
        return $configs->last()->max_years;
    }
}
