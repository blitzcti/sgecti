<?php

namespace App\Models;

use App\Models\Utils\Active;
use App\Models\Utils\Phone;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Model for supervisors table.
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
 * @property-read string formatted_phone
 */
class Supervisor extends Model
{
    use Active;
    use Phone;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
