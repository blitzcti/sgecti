<?php

namespace App\Models;

class Coordinator extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'start_date', 'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
