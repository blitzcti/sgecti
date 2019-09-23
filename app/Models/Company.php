<?php

namespace App\Models;

use Carbon\Carbon;

class Company extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'ie', 'pj', 'name', 'fantasy_name', 'email', 'phone', 'representative_name', 'representative_role', 'active', 'address_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pj' => 'boolean',
        'address_id' => 'integer',

        'active' => 'boolean',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'company_courses');
    }

    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'company_sectors');
    }

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function hasAgreementAt(Carbon $date = null)
    {
        if ($date == null) {
            $date = Carbon::now();
        }

        foreach ($this->agreements as $agreement) {
            $endDate = $agreement->end_date;
            $endDate->modify('-1 day');
            if ($agreement->active && $date->between($agreement->start_date, $endDate)) {
                return true;
            }
        }

        return false;
    }

    public function syncCourses($courses)
    {
        $this->courses()->sync($courses);
    }

    public function syncSectors($sectors)
    {
        $this->sectors()->sync($sectors);
    }
}
