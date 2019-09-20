<?php

namespace App\Models;

class State extends Model
{
    public const OPEN = 1;
    public const FINISHED = 2;
    public const CANCELED = 3;
    public const INVALID = 3;

    protected $fillable = [
        'description',
    ];

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
