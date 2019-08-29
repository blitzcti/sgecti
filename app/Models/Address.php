<?php

namespace App\Models;

class Address extends Model
{
    protected $fillable = [
        'cep', 'uf', 'city', 'street', 'complement', 'number', 'district',
    ];

    public function company()
    {
        return $this->hasOne(Company::class);
    }
}
