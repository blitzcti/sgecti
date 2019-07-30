<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

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
        'name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function coordinators()
    {
        return $this->hasMany(Coordinator::class)
            ->WhereDate('end_date', '>=', Carbon::today()->toDateString())
            ->orWhereNull('end_date')->where('user_id', '=', $this->id);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function isCoordinator()
    {
        return sizeof($this->coordinators) > 0;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function getCoordinatorOfAttribute()
    {
        return $this->coordinators()->groupBy('course_id')->get('course_id')->map(function ($c) {
            return $c->course;
        });
    }

    public function getCoordinatorCoursesNameAttribute()
    {
        $str = '';
        $array = $this->coordinator_of->map(function ($c) {return $c->name; })->toArray();
        $last = array_slice($array, -1);
        $first = join(', ', array_slice($array, 0, -1));
        $both = array_filter(array_merge([$first], $last), 'strlen');
        $str = join(' e ', $both);
        return $str;
    }

    public function getPhoneFormatedAttribute()
    {
        $phone = $this->phone;
        $ddd = substr($phone, 0, 2);
        $p1 = (strlen($phone) == 10) ? substr($phone, 2, 4) : substr($phone, 2, 5);
        $p2 = (strlen($phone) == 10) ? substr($phone, 6, 4) : substr($phone, 7, 4);
        $str = "($ddd) $p1-$p2";
        return $str;
    }

    public function notify($shortStr, $str)
    {
        $notification = new Notification();
        $notification->user_id = $this->id;
        $notification->short_text = $shortStr;
        $notification->text = $str;
        $notification->save();
    }
}
