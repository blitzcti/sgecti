<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Class SystemConfiguration
 *
 * @package App\Models
 * @property int id
 * @property string name
 * @property string cep
 * @property string uf
 * @property string city
 * @property string street
 * @property string number
 * @property string district
 * @property string phone
 * @property string extension
 * @property string fax
 * @property string email
 * @property int agreement_expiration
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property-read string formatted_phone
 * @property-read string formatted_fax
 * @property-read string formatted_cep
 */
class SystemConfiguration extends Model
{
    protected $fillable = [
        'name', 'cep', 'uf', 'city', 'street', 'number', 'district', 'phone', 'extension', 'fax', 'email',
        'agreement_expiration',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'agreement_expiration' => 'integer',
    ];

    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        if ($phone == null) {
            return null;
        }

        $ddd = substr($phone, 0, 2);
        $p1 = (strlen($phone) == 10) ? substr($phone, 2, 4) : substr($phone, 2, 5);
        $p2 = (strlen($phone) == 10) ? substr($phone, 6, 4) : substr($phone, 7, 4);
        return "($ddd) $p1-$p2";
    }

    public function getFormattedFaxAttribute()
    {
        $phone = $this->phone;
        $ddd = substr($phone, 0, 2);
        $p1 = substr($phone, 2, 4);
        $p2 = substr($phone, 6, 4);
        return "($ddd) $p1-$p2";
    }

    public function getFormattedCepAttribute()
    {
        $cep = $this->cep;
        $p1 = substr($cep, 0, 5);
        $p2 = substr($cep, 5, 3);
        return "$p1-$p2";
    }

    public static function getAgreementExpiration(Carbon $date)
    {
        $configs = static::all()->sortBy('id');
        return $date->modify("+" . $configs->last()->agreement_expiration . " year")->format("Y-m-d");
    }

    /**
     * @return static
     */
    public static function getCurrent()
    {
        return static::all()->sortBy('id')->last();
    }
}
