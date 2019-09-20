<?php

namespace App\Models;

class GeneralConfiguration extends Model
{
    protected $fillable = [
        'max_years', 'min_year', 'min_semester', 'min_hours', 'min_months', 'min_months_ctps', 'min_grade',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'course_id' => 'integer',
        'max_years' => 'integer',
        'min_year' => 'integer',
        'min_semester' => 'integer',
        'min_hours' => 'integer',
        'min_months' => 'integer',
        'min_months_ctps' => 'integer',
        'min_grade' => 'float',
    ];

    public static function getMaxYears($date)
    {
        $configs = GeneralConfiguration::whereDate('created_at', '<=', $date)->get()->sortBy('id');
        return $configs->last()->max_years;
    }
}
