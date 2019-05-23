<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = [
        'nome', 'email', 'telefone', 'ativo', 'id_company',
    ];

    public function company()
    {
        return Company::findOrFail($this->id_company);
    }
}
