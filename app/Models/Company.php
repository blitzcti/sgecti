<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'pj', 'nome', 'nome_fantasia', 'email', 'telefone', 'representante', 'cargo', 'ativo', 'address_id',
    ];

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function courses()
    {
        return $this->hasMany(CompanyCourses::class);
    }

    public function sectors()
    {
        return $this->hasMany(CompanySector::class);
    }

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }

    public function agreement()
    {
        return $this->hasMany(Agreement::class);
    }
}
