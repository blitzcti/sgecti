<?php

namespace App\Models;

class JobCompany extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'ie', 'pj', 'name', 'fantasy_name', 'email', 'phone', 'representative_name', 'representative_role',
        'active',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'company_id');
    }
}
