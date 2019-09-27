<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Proposal
 *
 * @package App\Models
 * @property int id
 * @property int company_id
 * @property Carbon deadline
 * @property int schedule_id
 * @property int schedule_2_id
 * @property float remuneration
 * @property string description
 * @property string requirements
 * @property string benefits
 * @property string contact
 * @property int type
 * @property string observation
 * @property Carbon approved_at
 * @property string reason_to_reject
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Company company
 * @property Schedule schedule
 * @property Schedule schedule2
 * @property Collection|Course[] courses
 */
class Proposal extends Model
{
    public const INTERNSHIP = 0;
    public const IC = 1;

    protected $fillable = [
        'company_id', 'deadline', 'schedule_id', 'schedule_2_id', 'remuneration', 'description', 'requirements',
        'benefits', 'contact', 'type', 'observation', 'approved_at', 'reason_to_reject'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',
        'schedule_id' => 'integer',
        'schedule_2_id' => 'integer',
        'type' => 'integer',

        'remuneration' => 'float',

        'deadline' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function schedule2()
    {
        return $this->belongsTo(Schedule::class, 'schedule_2_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'proposal_courses');
    }

    public function syncCourses($courses)
    {
        $this->courses()->sync($courses);
    }

    public static function approved()
    {
        return static::where('approved_at', '<>', null)->where('deadline', '>=', Carbon::today())->get();
    }
}
