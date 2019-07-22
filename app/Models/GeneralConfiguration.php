<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralConfiguration extends Model
{
    protected $fillable = [
        'max_years', 'start_date', 'end_date',
    ];
}
