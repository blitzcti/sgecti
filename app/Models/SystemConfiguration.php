<?php

namespace App\Models;

class SystemConfiguration extends Model
{
    protected $fillable = [
        'name', 'cep', 'uf', 'city', 'street', 'number', 'district', 'phone', 'email', 'extension', 'agreement_expiration',
    ];

    public static function getAgreementExpiration() {
        $configs = SystemConfiguration::all()->sortBy('id');
        return $configs->last()->agreement_expiration;
    }
}
