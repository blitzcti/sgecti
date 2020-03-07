<?php

namespace App\Models;

use App\Models\NSac\Student;
use App\Models\Utils\Phone;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Model for users table.
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string phone
 * @property string password
 * @property Carbon password_change_at
 * @property string remember_token
 * @property string api_token
 * @property Carbon email_verified_at
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Permission[] permissions
 * @property Collection|Role[] roles
 * @property Collection|DatabaseNotification[] notifications
 * @property Collection|DatabaseNotification[] readNotifications
 * @property Collection|DatabaseNotification[] unreadNotifications
 * @property Collection|Coordinator[] coordinators
 * @property Company company
 * @property Student student
 * @property-read Collection|Course[] coordinator_of
 * @property-read Collection|Course[] non_temp_coordinator_of
 * @property-read int[] coordinator_courses_id
 * @property-read int[] non_temp_coordinator_courses_id
 * @property-read string coordinator_courses_name
 * @property-read string formatted_phone
 */
class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;
    use Phone;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'password_change_at', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'password_change_at' => 'datetime',
        'email_verified_at' => 'datetime',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->connection = config('broker.useSSO') ? config('database.sso') : config('database.default');
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class)
            ->where(function (Builder $query) {
                return $query->whereDate('end_date', '>', Carbon::today())
                    ->orWhereNull('end_date');
            });
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isTeacher()
    {
        return $this->hasRole('teacher');
    }

    public function isCoordinator($temp = true)
    {
        if (!$temp) {
            return sizeof($this->non_temp_coordinator_of) > 0;
        }

        return $this->hasRole('coordinator');
    }

    public function isCompany()
    {
        return $this->hasRole('company');
    }

    public function company()
    {
        if (!$this->isCompany()) {
            return null;
        }

        return $this->belongsTo(Company::class, 'email', 'email');
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function student()
    {
        if (!$this->isStudent()) {
            return null;
        }

        return $this->belongsTo(Student::class, 'email', 'email2');
    }

    public function getCoordinatorOfAttribute()
    {
        return $this->coordinators()->groupBy('course_id')->get('course_id')->map(function (Coordinator $c) {
            return $c->course;
        });
    }

    public function getNonTempCoordinatorOfAttribute()
    {
        return $this->coordinators()->whereNull('temp_of')->groupBy('course_id')->get('course_id')->map(function (Coordinator $c) {
            return $c->course;
        });
    }

    public function getCoordinatorCoursesIdAttribute()
    {
        return $this->coordinator_of->map(function (Course $course) {
            return $course->id;
        })->toArray();
    }

    public function getNonTempCoordinatorCoursesIdAttribute()
    {
        return $this->non_temp_coordinator_of->map(function (Course $course) {
            return $course->id;
        })->toArray();
    }

    public function getCoordinatorCoursesNameAttribute()
    {
        $array = $this->coordinator_of->map(function (Course $c) {
            return $c->name;
        })->toArray();

        $last = array_slice($array, -1);
        $first = join(', ', array_slice($array, 0, -1));
        $both = array_filter(array_merge([$first], $last), 'strlen');
        return join(' e ', $both);
    }
}
