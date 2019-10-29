<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Model for coordinators table.
 *
 * @package App\Models
 * @property int id
 * @property int user_id
 * @property int course_id
 * @property Carbon start_date
 * @property Carbon end_date
 * @property int temp_of
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property User user
 * @property Course course
 * @property Coordinator temporary_of
 */
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
        return static::where('end_date', '>', Carbon::today()->toDateString())->orderBy('id')->get();
    }

    public static function expiredToday()
    {
        return static::where('end_date', '=', Carbon::today()->toDateString())->orderBy('id')->get();
    }
}
