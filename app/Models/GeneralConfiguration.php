<?php

namespace App\Models;

class GeneralConfiguration extends Model
{
    protected $fillable = [
        'max_years', 'start_date', 'end_date',
    ];
}
