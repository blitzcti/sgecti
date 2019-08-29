<?php

namespace App\Models;

use Carbon\Carbon;

class Company extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'ie', 'pj', 'name', 'fantasy_name', 'email', 'phone', 'representative_name', 'representative_role', 'active', 'address_id',
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

    public function hasAgreementAt(Carbon $date = null)
    {
        if ($date == null) {
            $date = Carbon::today();
        }

        foreach ($this->agreements as $agreement) {
            $startDate = Carbon::createFromTimeString($agreement->created_at);
            $endDate = Carbon::createFromFormat("Y-m-d", $agreement->expiration_date);
            if ($date->between($startDate, $endDate)) {
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
