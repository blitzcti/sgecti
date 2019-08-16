<?php

namespace App\Models;

use Carbon\Carbon;

class SystemConfiguration extends Model
{
    protected $fillable = [
        'name', 'cep', 'uf', 'city', 'street', 'number', 'district', 'phone', 'email', 'extension', 'agreement_expiration',
    ];

    public static function getAgreementExpiration() {
        $configs = SystemConfiguration::all()->sortBy('id');
        return Carbon::now()->modify("+" . $configs->last()->agreement_expiration . " year")->format("Y-m-d");
    }
}
