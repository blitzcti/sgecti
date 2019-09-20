<?php

namespace App\Models;

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
