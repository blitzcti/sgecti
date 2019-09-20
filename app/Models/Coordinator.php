<?php

namespace App\Models;

use Carbon\Carbon;

class Coordinator extends Model
{
    protected $fillable = [
        'user_id', 'course_id', 'start_date', 'end_date', 'temp_of',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'course_id' => 'integer',
        'temp_of' => 'integer',

        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function temporary_of()
    {
        return $this->belongsTo(Coordinator::class, 'temp_of');
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
