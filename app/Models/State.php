<?php

namespace App\Models;

class State extends Model
{
    protected $fillable = [
        'description',
    ];

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
