<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class Supervisor
 *
 * @package App\Models
 * @property int id
 * @property string name
 * @property string email
 * @property string phone
 * @property boolean active
 * @property int company_id
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Company company
 * @property Collection|Internship[] internships
 */
class Supervisor extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'active', 'company_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'company_id' => 'integer',

        'active' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
