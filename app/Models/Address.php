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

    public function getFormattedCepAttribute()
    {
        $cep = $this->cep;
        $p1 = substr($cep, 0, 5);
        $p2 = substr($cep, 5, 3);
        return "$p1-$p2";
    }
}
