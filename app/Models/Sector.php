<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = [
        'nome', 'descricao', 'ativo',
    ];

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_courses');
    }
}
