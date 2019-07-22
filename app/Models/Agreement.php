<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
        'company_id', 'expiration_date', 'observation',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
