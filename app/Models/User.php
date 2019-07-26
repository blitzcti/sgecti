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
        ->where('end_date', '=', null)
            ->orWhere('end_date', '>=', Carbon::today()->toDateString());
            //->groupBy('course_id')
        //->get()->sortBy('id');
        /*if ($this->hasRole('teacher')) {
            $coordinator = Coordinator::where('user_id', '=', $this->id)
                ->where(function ($query) {
                    $query->where('end_date', '=', null)
                        ->orWhere('end_date', '>=', Carbon::today()->toDateString());
                })
                ->get()->sortBy('id');

            if (sizeof($coordinator) > 0) {
                return $coordinator->last();
            }
        }

        return null;*/
    }

    public function isCoordinator()
    {
        return $this->coordinators != null;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
