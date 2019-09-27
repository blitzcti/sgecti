<?php

namespace App\Models;

use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Course
 *
 * @package App\Models
 * @property int id
 * @property string name
 * @property int color_id
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Student[] students
 * @property Collection|Coordinator[] coordinators
 * @property Collection|Coordinator[] non_temp_coordinators
 * @property Collection|CourseConfiguration[] configurations
 * @property Color color
 * @property Collection|Company[] companies
 * @property Collection|Proposal[] proposals
 */
class Course extends Model
{
    protected $fillable = [
        'name', 'color_id', 'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'color_id' => 'integer',

        'active' => 'boolean',
    ];

    public function getStudentsAttribute()
    {
        return Student::actives()->where('course_id', '=', $this->id);
    }

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class);
    }

    public function configurations()
    {
        return $this->hasMany(CourseConfiguration::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_courses');
    }

    public function proposals()
    {
        return $this->belongsToMany(Proposal::class, 'proposal_courses');
    }

    public function coordinatorAt($date)
    {
        $coordinator = $this->coordinators->where('end_date', $date != null ? '>' : '=', $date)->where('temp_of', '=', null)->sortBy('id');
        return $coordinator->last();
    }

    public function coordinator()
    {
        $coordinator = $this->coordinatorAt(Carbon::today()->toDateString()) ?? $this->coordinatorAt(null);
        return $coordinator;
    }

    public function getNonTempCoordinatorsAttribute()
    {
        return $this->coordinators->where('temporary_of', '=', null)->sortBy('id');
    }

    public function configurationAt($dateTime)
    {
        $config = $this->configurations->where('created_at', '<=', $dateTime)->sortBy('id');
        return $config->last() ?? GeneralConfiguration::all()->where('created_at', '<=', $dateTime)->sortBy('id')->last();
    }

    public function configuration()
    {
        return $this->configurationAt(Carbon::now());
    }
}
