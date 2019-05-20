<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'cep', 'uf', 'cidade', 'rua', 'complemento', 'numero', 'bairro',
    ];
}
