<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GeneralConfiguration extends Model
{
    protected $fillable = [
        'anos_max', 'data_inicio', 'data_fim',
    ];
}
