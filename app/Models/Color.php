<?php

namespace App\Models;

class Color extends Model
{
    protected $fillable = [
        'name',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
