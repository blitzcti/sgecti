<?php

namespace App\Models;

use App\Models\NSac\Student;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Auth;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @package App\Models
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
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
 * @property Collection|DatabaseNotification[] notifications
 * @property Collection|Coordinator[] coordinators
 * @property Company company
 * @property Student student
 * @property-read Collection|Course[] coordinator_of
 * @property-read Collection|Course[] non_temp_coordinator_of
 * @property-read int[] coordinator_courses_id
 * @property-read string coordinator_courses_name
 * @property-read string formatted_phone
 */
class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
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
        if (config('broker.useSSO')) {
            $this->connection = config('database.sso');
        }
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class)
            ->WhereDate('end_date', '>', Carbon::today()->toDateString())
            ->orWhereNull('end_date')->where('user_id', '=', $this->id);
    }

    public function isCoordinator($temp = true)
    {
        if ($temp) {
            return sizeof($this->coordinators) > 0;
        } else {
            return sizeof($this->coordinators->where('temp_of', '<>', null)) > 0;
        }
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isCompany()
    {
        return $this->hasRole('company');
    }

    public function company()
    {
        if ($this->isCompany()) {
            return $this->belongsTo(Company::class, 'email', 'email');
        }

        return null;
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function student()
    {
        if ($this->isStudent()) {
            return $this->belongsTo(Student::class, 'email', 'email2');
        }

        return null;
    }

    public function getCoordinatorOfAttribute()
    {
        return $this->coordinators()->groupBy('course_id')->get('course_id')->map(function ($c) {
            return $c->course;
        });
    }

    public function getNonTempCoordinatorOfAttribute()
    {
        return $this->coordinators()->where('temp_of', '<>', null)->groupBy('course_id')->get('course_id')->map(function ($c) {
            return $c->course;
        });
    }

    public function getCoordinatorCoursesIdAttribute()
    {
        return $this->coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();
    }

    public function getNonTempCoordinatorCoursesIdAttribute()
    {
        return $this->non_temp_coordinator_of->map(function ($course) {
            return $course->id;
        })->toArray();
    }

    public function getCoordinatorCoursesNameAttribute()
    {
        $array = $this->non_temp_coordinator_of->map(function ($c) {
            return $c->name;
        })->toArray();

        $last = array_slice($array, -1);
        $first = join(', ', array_slice($array, 0, -1));
        $both = array_filter(array_merge([$first], $last), 'strlen');
        return join(' e ', $both);
    }

    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        $ddd = substr($phone, 0, 2);
        $p1 = (strlen($phone) == 10) ? substr($phone, 2, 4) : substr($phone, 2, 5);
        $p2 = (strlen($phone) == 10) ? substr($phone, 6, 4) : substr($phone, 7, 4);
        return "($ddd) $p1-$p2";
    }
}
