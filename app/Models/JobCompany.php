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
 * @property-read string formatted_cpf_cnpj
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

    public function getFormattedCpfCnpjAttribute()
    {
        $cpf_cnpj = $this->cpf_cnpj;
        if ($this->pj) {
            $p1 = substr($cpf_cnpj, 0, 2);
            $p2 = substr($cpf_cnpj, 2, 3);
            $p3 = substr($cpf_cnpj, 5, 3);
            $p4 = substr($cpf_cnpj, 8, 4);
            $p5 = substr($cpf_cnpj, 12, 2);
            return "$p1.$p2.$p3/$p4-$p5";
        } else {
            $p1 = substr($cpf_cnpj, 0, 3);
            $p2 = substr($cpf_cnpj, 3, 3);
            $p3 = substr($cpf_cnpj, 6, 3);
            $p4 = substr($cpf_cnpj, 9, 2);
            return "$p1.$p2.$p3-$p4";
        }
    }
}
