<?php

namespace App\Models;

use Carbon\Carbon;

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

    public static function actives()
    {
        return Coordinator::where('end_date', '>', Carbon::today()->toDateString())->orderBy('id')->get();
    }

    public static function expiredToday()
    {
        return Coordinator::where('end_date', '=', Carbon::today()->toDateString())->orderBy('id')->get();
    }
}
