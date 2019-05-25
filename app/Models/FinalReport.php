<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalReport extends Model
{
    protected $fillable = [
        'internship_id', 'dia',
        'nota_1_a', 'nota_1_b', 'nota_1_c', 'nota_1_d', 'nota_2_a', 'nota_2_b', 'nota_2_c', 'nota_2_d', 'nota_3_a', 'nota_3_b', 'nota_4_a', 'nota_4_b', 'nota_4_c',
        'nota_final', 'horas_cumpridas', 'data_termino', 'numero_aprovacao', 'coordinator_id', 'observacao',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function coordinator()
    {
        return $this->belongsTo(Coordinator::class);
    }
}
