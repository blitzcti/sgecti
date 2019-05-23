<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amendment extends Model
{
    protected $fillable = [
        'id_internship', 'data_ini', 'data_fim', 'id_schedule', 'protocolo', 'observacao',
    ];
}
