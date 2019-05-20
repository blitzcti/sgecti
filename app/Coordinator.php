<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    protected $fillable = [
        'id_user', 'id_course', 'vigencia_ini', 'vigencia_fim',
    ];
}
