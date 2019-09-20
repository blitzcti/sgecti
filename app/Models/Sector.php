<?php

namespace App\Models;

class Sector extends Model
{
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
}
