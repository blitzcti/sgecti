<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'cep', 'uf', 'cidade', 'rua', 'complemento', 'numero', 'bairro',
    ];
}
