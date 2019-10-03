<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class GeneralConfiguration
 *
 * @package App\Models
 * @property int id
 * @property int max_years
 * @property int min_year
 * @property int min_semester
 * @property int min_hours
 * @property int min_months
 * @property int min_months_ctps
 * @property float min_grade
 * @property Carbon created_at
 * @property Carbon updated_at
 */
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
        $configs = static::whereDate('created_at', '<=', $date)->get()->sortBy('id');
        return $configs->last()->max_years;
    }
}
