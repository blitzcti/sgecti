<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BimestralReport extends Model
{
    protected $fillable = [
        'id_internship', 'dia', 'protocolo',
    ];
}
