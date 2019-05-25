<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amendment extends Model
{
    protected $fillable = [
        'internship_id', 'data_ini', 'data_fim', 'schedule_id', 'protocolo', 'observacao',
    ];

    public function internship()
    {
        return $this->hasOne(Internship::class);
    }
}
