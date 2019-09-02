<?php

namespace App\Models;

class Agreement extends Model
{
    protected $fillable = [
        'company_id', 'start_date', 'end_date', 'observation',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
