<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'ra', 'id_ctps', 'id_company', 'id_sector', 'id_coordinator', 'id_schedule', 'id_state', 'data_ini',
        'data_fim', 'protocolo', 'atividades', 'observacao', 'motivo_cancelamento', 'ativo',
    ];
}
