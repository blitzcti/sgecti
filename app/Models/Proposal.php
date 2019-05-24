<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'name', 'id_company', 'id_course', 'data_limite', 'id_schedule', 'remuneracao', 'descricao', 'observacao',
    ];
}