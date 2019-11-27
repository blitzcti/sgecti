<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

/**
 * Model for agreements table.
 *
 * @package App\Models
 * @property int id
 * @property int company_id
 * @property Carbon start_date
 * @property Carbon end_date
 * @property string observation
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Company company
 */
class Agreement extends Model
{
    protected $fillable = [
        'company_id', 'start_date', 'end_date', 'observation', 'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',

        'start_date' => 'date',
        'end_date' => 'date',

        'active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function createUser()
    {
        $user = new User();
        $user->password = Hash::make('123456789');
        $user->email = $this->company->email;
        $user->phone = null;
        $user->name = $this->company->representative_name;
        $user->assignRole('company');
        $user->delete();
        return $user->save();
    }

    public function deleteUser()
    {
        $user = $this->company->user;

        if ($user != null) {
            return $user->delete();
        }
    }

    public static function expiredToday()
    {
        return static::where('end_date', '=', Carbon::today()->toDateString())->orderBy('id')->get();
    }
}
