<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'cpf_cnpj', 'pj', 'nome', 'nome_fantasia', 'email', 'telefone', 'representante', 'cargo', 'ativo', 'id_address',
    ];
}
