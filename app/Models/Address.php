<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'cep', 'uf', 'city', 'street', 'complement', 'number', 'district',
    ];
}
