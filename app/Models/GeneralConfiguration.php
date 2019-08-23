<?php

namespace App\Models;

class GeneralConfiguration extends Model
{
    protected $fillable = [
        'max_years', 'min_year', 'min_semester', 'min_hours', 'min_months', 'min_months_ctps', 'min_grade',
    ];

    public static function getMaxYears($date) {
        $configs = GeneralConfiguration::whereDate('created_at', '<=', $date)->get()->sortBy('id');
        return $configs->last()->max_years;
    }
}
