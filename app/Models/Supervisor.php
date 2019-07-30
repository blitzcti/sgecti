<?php

namespace App\Models;

class Supervisor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'active', 'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
