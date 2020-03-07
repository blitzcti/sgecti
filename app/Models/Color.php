<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Model for colors table (used by courses).
 *
 * @package App\Models
 * @property int id
 * @property string name
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Course[] courses
 */
class Color extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
