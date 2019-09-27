<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class JobCompany
 *
 * @package App\Models
 * @property int id
 * @property string cpf_cnpj
 * @property string ie
 * @property boolean pj
 * @property string name
 * @property string fantasy_name
 * @property string email
 * @property string phone
 * @property string representative_name
 * @property string representative_role
 * @property boolean active
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Collection|Job[] jobs
 */
class JobCompany extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'ie', 'pj', 'name', 'fantasy_name', 'email', 'phone', 'representative_name', 'representative_role',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pj' => 'boolean',

        'active' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id');
    }
}
