<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = [
        'nome', 'email', 'telefone', 'ativo', 'company_id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
