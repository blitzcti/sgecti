<?php

namespace App\Models;

use Carbon\Carbon;

class SystemConfiguration extends Model
{
    protected $fillable = [
        'name', 'cep', 'uf', 'city', 'street', 'number', 'district', 'phone', 'email', 'extension', 'agreement_expiration',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'agreement_expiration' => 'integer',
    ];

    public static function getAgreementExpiration(Carbon $date)
    {
        $configs = SystemConfiguration::all()->sortBy('id');
        return $date->modify("+" . $configs->last()->agreement_expiration . " year")->format("Y-m-d");
    }
}
