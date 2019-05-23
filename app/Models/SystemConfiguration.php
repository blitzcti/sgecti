<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemConfiguration extends Model
{
    protected $fillable = [
        'nome', 'cep', 'uf', 'cidade', 'rua', 'numero', 'bairro', 'fone', 'email', 'ramal', 'validade_convenio',
    ];
}
