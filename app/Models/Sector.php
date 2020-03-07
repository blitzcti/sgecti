<?php

namespace App\Models;

use App\Models\Utils\Active;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Model for sectors table.
 *
 * @package App\Models
 * @property int id
 * @property string name
 * @property string description
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Company[] companies
 * @property Collection|Internship[] internships
 */
class Sector extends Model
{
    use Active;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_courses');
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
