<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    protected $fillable = [
        'nome', 'email', 'telefone', 'ativo', 'id_company',
    ];
}
