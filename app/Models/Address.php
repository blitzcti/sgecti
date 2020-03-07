<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * Model for addresses table.
 *
 * @package App\Models
 * @property int id
 * @property string cep
 * @property string uf
 * @property string city
 * @property string street
 * @property string complement
 * @property string number
 * @property string district
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Company company
 * @property-read string formatted_cep
 * @property-read string formatted_address
 */
class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        return "{$p1}-{$p2}";
    }

    public function getFormattedAddressAttribute()
    {
        return "{$this->street}, Nº {$this->number}";
    }
}
