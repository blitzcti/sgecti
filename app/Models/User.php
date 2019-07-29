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
        'name', 'email', 'password',
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
}
