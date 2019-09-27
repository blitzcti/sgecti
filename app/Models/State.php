<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class State
 *
 * @package App\Models
 * @property int id
 * @property string description
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Internship[] internships
 * @property Collection|Job[] jobs
 */
class State extends Model
{
    public const OPEN = 1;
    public const FINISHED = 2;
    public const CANCELED = 3;
    public const INVALID = 4;

    protected $fillable = [
        'description',
    ];

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
